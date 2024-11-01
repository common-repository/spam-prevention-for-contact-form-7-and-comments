<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.sitelint.com
 * @since      1.0.0
 *
 * @package    SLSP_SiteLintSpamPreventionPublic
 * @subpackage SLSP_SiteLintSpamPreventionPublic/public
 */
class SLSP_SiteLintSpamPreventionPublic
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $plugin_name       The name of the plugin.
     * @param    string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function initialisePreventionForCF7()
    {
      add_action('wp_print_footer_scripts', 'modifyContactForm7FormActionUrl', 1);
      function modifyContactForm7FormActionUrl()
      {
        $cfUniqueKey = hash('sha512', $_SERVER['DOCUMENT_ROOT']);

        echo "<script>";

        echo "(function () {\n";
        echo "const contactForm = document.querySelector('.wpcf7-form');\n";
        echo "if (contactForm) {" . "\n";
        echo " const handleCfScroll = () => {" . "\n";
          echo "  const inp = document.createElement('input');";
          echo "  inp.type = 'hidden';";
          echo "  inp.value = '" . esc_js($cfUniqueKey) . "';";
          echo "  inp.id = 'sp';";
          echo "  inp.name = 'sp';";
          echo "  contactForm.appendChild(inp);";
          echo "  document.removeEventListener('scroll', handleCfScroll);\n";
        echo " };" . "\n";

          echo "const clientRect = contactForm.getBoundingClientRect();\n";
          echo "const isWholeFormRenderedInTheBrowserWindow = (clientRect.top >= 0) && (clientRect.left >= 0) && (clientRect.bottom <= (window.innerHeight || document.documentElement.clientHeight)) && (clientRect.right <= (window.innerWidth || document.documentElement.clientWidth));\n";
          echo "if (isWholeFormRenderedInTheBrowserWindow) {";
          echo "  handleCfScroll();";
          echo "} else {";
          echo "  document.addEventListener('scroll', handleCfScroll);";
          echo "}";

        echo "}" . "\n";
        echo "})();\n";

        echo "</script>";
      }

      add_action("wpcf7_before_send_mail", 'handleSubmitContactForm7FormAction', 10, 3);

      function handleSubmitContactForm7FormAction($contact_form, &$abort, $submission)
      {
        $wpcfRequestedTokenOriginalValue = hash('sha512', $_SERVER['DOCUMENT_ROOT']);
        $wpcfRequestedTokenIncomingValue = $submission->get_posted_data('sp');

        if (empty($wpcfRequestedTokenIncomingValue)
          || $wpcfRequestedTokenIncomingValue !== $wpcfRequestedTokenOriginalValue
        ) {
          $abort = true;
        }

        return $submission;
      }
    }

    public function initialisePreventionForWpComments()
    {
      add_filter('comment_form_defaults', 'removeCommentActionUrlFromCommentForm', 99);
      function removeCommentActionUrlFromCommentForm($defaults)
      {
        $defaults['action'] = '#';
        return $defaults;
      }

      add_action('wp_print_footer_scripts', 'modifyWpCommentFormActionUrl', 1);

      function modifyWpCommentFormActionUrl()
      {
        if (is_singular() && comments_open()) {
          $commentUniqueKey  = password_hash($_SERVER['DOCUMENT_ROOT'], PASSWORD_BCRYPT);

          echo "<script>";
          echo "(function () {\n";
          echo "const commentForm = document.querySelector('#commentform, #ast-commentform, #fl-comment-form, #ht-commentform');" . "\n";
          echo "if (commentForm) {" . "\n";
            echo " const handleScroll = () => {" . "\n";
              echo '  commentForm.action = "' . esc_url(get_site_url() . '/wp-comments-post.php?' . $commentUniqueKey) . '";' . "\n";
              echo "  document.removeEventListener('scroll', handleScroll);\n";
            echo ' };' . "\n";
          echo " document.addEventListener('scroll', handleScroll);\n";
          echo '}';
          echo "})()\n";
          echo "</script>";
        }
      }

      add_action('pre_comment_on_post', 'handleWpCommentFormSubmitAction', 1);

      function handleWpCommentFormSubmitAction()
      {
        $url = wp_parse_url($_SERVER['REQUEST_URI']);
        $commentRequestedKey = password_hash($_SERVER['DOCUMENT_ROOT'], PASSWORD_BCRYPT);
        $commentRequestMethod = isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST" ;

        if (!$commentRequestMethod || isset($url[$commentRequestedKey])) {
          wp_die('Comments service temporary unavailable', 'Warning', ['response' => 400, 'exit' => true]);
        }
      }
    }

    /**
     * Register the footer.
     *
     * @since    1.0.0
     */
    public function add_logo()
    {
      echo '<a href="https://www.sitelint.com/" title="Spam protection for WP Contact Form 7 and WordPress comments" rel="noopener" target="_blank" style="display: inline-flex; height: 16px; left: 4px; line-height: initial; margin: -24px 0 0 0; position: absolute; padding: 0 0 0 0;">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewbox="0 0 16 16"
          aria-hidden="true" focusable="false"><path fill="#0069c4" d="M0 0h16v16H0Z" />
          <path d="M4.316 10.489q3.41.187 4.617.187.287 0 .448-.162.174-.174.174-.46v-1.12H6.693q-1.306
          0-1.904-.586-.585-.597-.585-1.904v-.373q0-1.307.585-1.892.598-.597 1.904-.597h4.368v1.742h-3.87q-.747
          0-.747.747v.249q0 .746.747.746h2.24q1.22 0 1.792.573.572.572.572 1.792v.622q0 1.22-.572
          1.792-.573.572-1.792.572-.635 0-1.344-.024l-1.145-.05q-1.27-.062-2.626-.174z" fill="#fff" />
          </svg><span style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px;
          overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">Real-user monitoring for Accessibility, Performance, Security, SEO & Errors (SiteLint)</span></a>';
    }
}
