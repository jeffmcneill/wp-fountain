<?php
/****************************************************************************
Plugin Name: WP Fountain
Plugin URI: http://mcneill.io/wp-fountain/
Description: Modifies screenplay format text for inclusion in web pages. Based on the scrippet concept and original code by <a href="http://johnaugust.com">John August</a> and <a href="http://equinox-of-insanity.com">Nima Yousefi</a>
Author: Jeff Mcneill
Author URI: http://mcneill.io
Version: 1.5.9

This plugin uses the function found in the file "fountainize.php" to create the
formatted HTML.
****************************************************************************/

require('fountainize.php');

if ( ! defined( 'WP_CONTENT_URL' ) )
    define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
    define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
    define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

add_filter('the_content', 'build_fountain', 1, 1);
add_filter('comment_text', 'build_fountain', 1, 1);
add_action('wp_head', 'add_fountain_css');
add_action('admin_menu', 'add_fountains_admin_panel');

function build_fountain($text) {
    $settings    = get_option('fountain_options');
    $wrap_before = '';
    $wrap_after  = '';

    if($settings['border_style'] == 'Drop Shadow') {
        $wrap_before = "<div class=\"fountain-shadow\">\n<div class=\"inner-shadow\">\n";
        $wrap_after  = "</div>\n</div>\n";
    }
    $text = fountainize($text, $wrap_before, $wrap_after);  // see fountainize.php for details
    return $text;
}


// Options & Admin Stuff
$default_options  = array('width' => '400', 'bg_color' => '#FFFFFC', 'text_color' => '#000000', 'border_style' => 'Simple', 'alignment' => 'Left');

if(!get_option('fountain_options')) {
    update_option('fountain_options', $default_options); // create the defaults
}

function add_fountain_css($u) {
    // add the base CSS
    echo '<link rel="stylesheet" type="text/css" href="' . WP_PLUGIN_URL . '/wp-fountain/fountains.css">' . "\n";

    // now modify CSS if necessary
    $settings = get_option('fountain_options');
    echo "\n\n<style>\n";
    echo "div.fountain {\n";
    echo "\twidth: {$settings['width']}px;\n";
    echo "\tbackground-color: " . $settings['bg_color'] . ";\n";
    echo "\tcolor: {$settings['text_color']};\n";

    if($settings['alignment'] == 'Center' && $settings['border_style'] != 'Drop Shadow') {
        echo "\tmargin: 0 auto 16px auto !important;";
    }


    echo "}\n</style>\n\n";   // close the div.fountain CSS block

    if($settings['border_style'] == 'Drop Shadow') {
        $shadow_width = $settings['width'] + 50;
        echo '<link rel="stylesheet" type="text/css" href="' . WP_PLUGIN_URL . '/wp-fountain/fountain_shadow.css">' . "\n";
        echo "<style>\n";
        echo "div.fountain {\n\tmargin-left: 0 !important; \n}\n\n";
        echo "div.inner-shadow {\n\tbackground-color: {$settings['bg_color']} !important; \n}\n\n";
        echo "div.fountain-shadow {\n\twidth: {$shadow_width}px;\n";
        if($settings['alignment'] == 'Center') {
            echo "\tmargin: 0 auto;\n";
        }
        echo "}\n</style>\n\n";
    }

    echo "<!--[if IE]>\n<style>";
    echo "div.fountain { margin-bottom: 0px !important; }\n";
    echo "</style>\n<![endif]-->\n\n";

    if (stristr($_SERVER['HTTP_USER_AGENT'], 'iPhone')) {   // need to modify the font to work with the iPhone
        echo "<style>\n\t.fountain p { font: 7px/9px Courier, 'Courier New', monospace !important; }\n</style>\n\n";
    }

    if (stristr($_SERVER['HTTP_USER_AGENT'], 'Windows')) {   // need to modify the font to work better on Windows
        echo "<style>\n\t.fountain p { font-family: 'Courier New', monospace !important; }\n</style>\n\n";
    }

}

function fountains_options_panel() {
    global $default_options;
    $settings = get_option('fountain_options');
    $cs_home  = WP_PLUGIN_URL . '/wp-fountain/colorselector';
    ?>
    <script type="text/javascript" charset="utf-8">
        function reset_fields() {
            var form = document.getElementById('fountains_form');
            form.width.value = '<?php echo $default_options['width'] ?>';
            form.bg_color.value = '<?php echo $default_options['bg_color'] ?>';
            form.text_color.value = '<?php echo $default_options['text_color'] ?>';
            form.border_style.selectedIndex = '<?php echo $default_options['border_style'] ?>';
            form.alignment.selectedIndex = '<?php echo $default_options['alignment'] ?>';
        }

        // set the values for the colorselector
        var CROSSHAIRS_LOCATION = '<?php echo $cs_home; ?>/crosshairs.png';
        var HUE_SLIDER_LOCATION = '<?php echo $cs_home; ?>/h.png';
        var HUE_SLIDER_ARROWS_LOCATION = '<?php echo $cs_home; ?>/position.png';
        var SAT_VAL_SQUARE_LOCATION = '<?php echo $cs_home; ?>/sv.png';
    </script>
    <script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/wp-fountain/colorselector.js"></script>
    <div class="wrap">
        <h2>Fountains Options</h2>
        <p>These are the fountain options that you can modify. If you'd like to return the
            options to their default state click the reset button in the bottom right corner of the page.</p>
        <form action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>" method="post" id="fountains_form">
            <input type="hidden" name="action" value="save_options" />
            <table class="form-table">
                <tr align="top">
                    <th scope="row"><label for="width">Width of the Scippet box</label></th>
                    <td colspan="3"><input type="text" name="width" value="<?php echo $settings['width']; ?>" id="width" style="width:120px;"/> Default: <b><i><?php echo $default_options['width'] ?></i></b><br/>
                        Defines the width of the fountain box in pixels. </td>
                </tr>
                <tr align="top">
                    <th scope="row"><label for="border_style">Border Style</label></th>
                    <td colspan="3"><select name="border_style" style="width:120px;">
                            <option name="Simple" <?php if($settings['border_style'] == 'Simple') { echo 'selected'; } ?>>Simple</option>
                            <option name="Drop Shadow" <?php if($settings['border_style'] == 'Drop Shadow') { echo 'selected'; } ?>>Drop Shadow</option>
                        </select> Default: <b><i><?php echo $default_options['border_style'] ?></i></b><br/></td>
                </tr>
                <tr align="top">
                    <th scope="row"><label for="alignment">Alignment</label></th>
                    <td colspan="3"><select name="alignment" style="width:120px;">
                            <option name="Left" <?php if($settings['alignment'] == 'Left') { echo 'selected'; } ?>>Left</option>
                            <option name="Center" <?php if($settings['alignment'] == 'Center') { echo 'selected'; } ?>>Center</option>
                        </select> Default: <b><i><?php echo $default_options['alignment'] ?></i></b><br/>
                        The alignment of the fountain box on the page. </td>
                </tr>

                <tr align="top">
                    <th scope="row"><label for="bg_color">Background color</label></th>
                    <td><input type="text" name="bg_color" value="<?php echo $settings['bg_color']; ?>" id="bg_color" class="color" size="8"/><br/>
                        Default: <b><i><?php echo $default_options['bg_color'] ?></i></b>.</td>
                    <th scope="row"><label for="text_color">Text Color</label></th>
                    <td><input type="text" name="text_color" value="<?php echo $settings['text_color'] ?>" id="text_color" class="color" size="8"/><br/>
                        Default: <b><i><?php echo $default_options['text_color'] ?></i></b></td>
                </tr>

            </table>

            <p class="submit">
                <input type="submit" value="Save Changes" style="float: left;">
                <input type="submit" onclick="javascript:reset_fields();" value="Reset to Original Options" style="float:right;">
                <p style="clear:both;"></p>
            </p>
        </form>
    </div>
    <?php
}

function add_fountains_admin_panel() {
    add_options_page('fountains', 'fountains', 8, __FILE__, 'fountains_options_panel');
}

function fountains_save_options() {
    // Get all the options from the $_POST
    $fountain_options['width']          = $_POST['width'];
    $fountain_options['bg_color']       = $_POST['bg_color'];
    $fountain_options['text_color']     = $_POST['text_color'];
    $fountain_options['border_style']   = $_POST['border_style'];
    $fountain_options['alignment']      = $_POST['alignment'];

    update_option('fountain_options', $fountain_options);
}

if ($_POST['action'] == 'save_options'){
	fountains_save_options();
}

?>
