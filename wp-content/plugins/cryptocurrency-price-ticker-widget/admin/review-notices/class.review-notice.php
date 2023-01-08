<?php

if (!class_exists('ccpw_review_notice')):
    class ccpw_review_notice
{
        const PLUGIN = 'Cryptocurrency Widgets';
        const SLUG = 'ccpw';
        const LOGO = CCPWF_URL . 'assets/crypto-widget.png';
        const SPARE_ME = 'ccpw_spare_me';
        const ACTIVATE_TIME = 'ccpw_activation_time';
        const REVIEW_LINK = 'https://wordpress.org/support/plugin/cryptocurrency-price-ticker-widget/reviews/#new-post';
        const AJAX_REQUEST = 'ccpw_dismiss_notice';
    }
endif;

if (!class_exists('CCPW_Review_Class')) {
    class CCPW_Review_Class
    {
        /**
         * The Constructor
         */
        public function __construct()
        {
            // register actions

            if (is_admin()) {
                add_action('admin_notices', array($this, 'atlt_admin_notice_for_reviews'));
                add_action('wp_ajax_' . ccpw_review_notice::AJAX_REQUEST, array($this, 'atlt_dismiss_review_notice'));
            }
        }

        // ajax callback for review notice
        public function atlt_dismiss_review_notice()
        {
            $rs = update_option(ccpw_review_notice::SPARE_ME, 'yes');
            echo json_encode(array("success" => "true"));
            exit;
        }
        // admin notice
        public function atlt_admin_notice_for_reviews()
        {

            if (!current_user_can('update_plugins')) {
                return;
            }

            if (get_option(ccpw_review_notice::ACTIVATE_TIME)) {
                // get installation dates and rated settings
                $installation_date = date('Y-m-d h:i:s', (int) get_option(ccpw_review_notice::ACTIVATE_TIME));

            }

            // check user already rated
            if (get_option(ccpw_review_notice::SPARE_ME)) {
                return;
            }

            // grab plugin installation date and compare it with current date
            $display_date = date('Y-m-d h:i:s');
            $install_date = new DateTime($installation_date);
            $current_date = new DateTime($display_date);
            $difference = $install_date->diff($current_date);
            $diff_days = $difference->days;

            // check if installation days is greator then week
            if (isset($diff_days) && $diff_days >= 3) {
                echo $this->atlt_create_notice_content();
            }
        }

        // generated review notice HTML
        public function atlt_create_notice_content()
        {

            $ajax_url = admin_url('admin-ajax.php');
            $ajax_callback = ccpw_review_notice::AJAX_REQUEST;
            $wrap_cls = "notice notice-info is-dismissible";
            $img_path = ccpw_review_notice::LOGO;

            $p_name = ccpw_review_notice::PLUGIN;
            $like_it_text = 'Rate Now! ★★★★★';
            $already_rated_text = esc_html__('I already rated it', 'atlt2');
            $not_like_it_text = esc_html__('Not Interested', 'atlt2');
            $p_link = esc_url(ccpw_review_notice::REVIEW_LINK);

            $message = "Thanks for using <b>$p_name</b> -WordPress plugin.
        We hope you liked it! <br/>Please give us a quick rating, it works as a boost for us to keep working on more <a href='https://coolplugins.net' target='_blank'><strong>Cool Plugins</strong></a>!<br/>";

            $html = '<div data-ajax-url="%8$s"  data-ajax-callback="%9$s" class="' . ccpw_review_notice::SLUG . '-feedback-notice-wrapper %1$s">
        <div class="logo_container"><a href="%5$s"><img src="%2$s" alt="%3$s" style="max-width:80px;"></a></div>
        <div class="message_container">%4$s
        <div class="callto_action">
        <ul>
            <li class="love_it"><a href="%5$s" class="like_it_btn button button-primary" target="_new" title="%6$s">%6$s</a></li>
            <li class="already_rated"><a href="javascript:void(0);" class="already_rated_btn button ' . ccpw_review_notice::SLUG . '_dismiss_notice" title="%7$s">%7$s</a></li>
            <li class="already_rated"><a href="javascript:void(0);" class="already_rated_btn button ' . ccpw_review_notice::SLUG . '_dismiss_notice" title="%10$s">%10$s</a></li>
        </ul>
        <div class="clrfix"></div>
        </div>
        </div>
        </div>';

            $style = '<style>.' . ccpw_review_notice::SLUG . '-feedback-notice-wrapper.notice.notice-info.is-dismissible {
            padding: 5px;
            display: table;
            width: fit-content;
            max-width: 855px;
            clear: both;
            border-radius: 5px;
            border: 2px solid #b7bfc7;
        }
        .' . ccpw_review_notice::SLUG . '-feedback-notice-wrapper .logo_container {
            width: 100px;
            display: table-cell;
            padding: 5px;
            vertical-align: middle;
        }
        .' . ccpw_review_notice::SLUG . '-feedback-notice-wrapper .logo_container a,
        .' . ccpw_review_notice::SLUG . '-feedback-notice-wrapper .logo_container img {
            width:fit-content;
            height:auto;
            display:inline-block;
        }
        .' . ccpw_review_notice::SLUG . '-feedback-notice-wrapper .message_container {
            display: table-cell;
            padding: 5px 25px 5px 5px;
            vertical-align: middle;
        }
        .' . ccpw_review_notice::SLUG . '-feedback-notice-wrapper ul li {
            float: left;
            margin: 0px 10px 0 0;
        }
        .' . ccpw_review_notice::SLUG . '-feedback-notice-wrapper ul li.already_rated a:after {
            color: #e86011;
            content: "\f153";
            display: inline-block;
            vertical-align: middle;
            margin: -1px 0 0 5px;
            font-size: 15px;
            font-family: dashicons;
        }
        .' . ccpw_review_notice::SLUG . '-feedback-notice-wrapper ul li .button-primary {
            background: #e86011;
            text-shadow: none;
            border-color: #943b07;
            box-shadow: none;
        }
        .' . ccpw_review_notice::SLUG . '-feedback-notice-wrapper ul li .button-primary:hover {
            background: #222;
            border-color: #000;
        }
        .' . ccpw_review_notice::SLUG . '-feedback-notice-wrapper a {
            color: #008bff;
        }

        /* This css is for license registration page */
        .' . ccpw_review_notice::SLUG . '-notice-red.uninstall {
            max-width: 700px;
            display: block;
            padding: 8px;
            border: 2px solid #157d0f;
            margin: 10px 0;
            background: #13a50b;
            font-weight: bold;
            font-size: 13px;
            color: #ffffff;
        }
        .clrfix{
            clear:both;
        }</style>';

            $script = '<script>
        jQuery(document).ready(function ($) {
            $(".' . ccpw_review_notice::SLUG . '_dismiss_notice").on("click", function (event) {
                var $this = $(this);
                console.log("clicked!!!");
                var wrapper=$this.parents(".' . ccpw_review_notice::SLUG . '-feedback-notice-wrapper");
                var ajaxURL=wrapper.data("ajax-url");
                var ajaxCallback=wrapper.data("ajax-callback");

                $.post(ajaxURL, { "action":ajaxCallback }, function( data ) {
                    wrapper.slideUp("fast");
                  }, "json");

            });
        });
        </script>';

            $html .= '
        ' . $style . '
        ' . $script;

            return sprintf($html,
                $wrap_cls,
                $img_path,
                $p_name,
                $message,
                $p_link,
                $like_it_text,
                $already_rated_text,
                $ajax_url, // 8
                $ajax_callback, //9
                $not_like_it_text //10
            );

        }

    } //class end
    new CCPW_Review_Class();
}
