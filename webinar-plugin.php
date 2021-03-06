<?php
/**
 * Plugin Name:     Webinar Plugin
 * Plugin URI:      www.greengeeks.com
 * Description:     Gets the ball rolling
 * Author:          Marco Berrocal
 * Author URI:      www.webmentor.cr
 * Text Domain:     webinar-plugin
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Webinar_Plugin
 */

// Your code starts here.


/*

Defining new wp-cli commands in a class like 
ExamplePluginWPCLI confers a special advantage over defining them using only standalone php functions or closures: 
all public methods in classes passed to WP_CLI::add_command() are automatically registered with wp-cli as sub-commands.
*/

/* handling arguments

CLI supports both positional arguments and  and associative arguments.
positional - order matters

wp mycommand arg1 number 3

associative in any order and accept values =

wp mycommand --arg1=val1 --arg2=val2

wp my command the_child_theme_name --cpt=val1 --txv=val1




*/


// if ( defined( 'WP_CLI' ) && WP_CLI ) {

//     class BallRollingPluginWPCLI {

//         public function __construct() {

//                 // example constructor called when plugin loads

//         }

//         public function small_roll() {

//                 // give output
//                 WP_CLI::success( 'I am good go here!' );

//         }

//         public function big_roll( $args, $assoc_args ) {

//                 // process arguments 

//                 // do cool stuff

//                 // give output
//                 WP_CLI::success( 'hello from bigroll !' );
//                 WP_CLI::log( 'You said you wanted some' .$args["assoc_args"]. '?' );

//         }

//     }

//     WP_CLI::add_command( 'rolling', 'BallRollingPluginWPCLI' );

// }



if ( defined( 'WP_CLI' ) && WP_CLI ) {

    class BallRollingPluginWPCLI {

        public function __construct() {

                // example constructor called when plugin loads

        }

        private function roller_boy() {

            $my_message = WP_CLI::colorize( "%YWe are ready to commence CLI...%n " );
            WP_CLI::log( $my_message );
            
            $my_message = WP_CLI::colorize( "%BStep 1 installing theme... " );
            WP_CLI::log( $my_message );
            
            $theme_to_install = "client-theme";
            $options = array(
                'return'     => true,   // Return 'STDOUT'; use 'all' for full object.
                'launch'     => false,  // Reuse the current process.
                'exit_error' => true,   // Halt script execution on error.
            );

            $theme = WP_CLI::runcommand( 'scaffold child-theme ' .$theme_to_install. ' --parent_theme=twentytwenty', $options );
            
            $my_message = WP_CLI::colorize( "%GTheme has been created.. activating theme " );
            WP_CLI::log( $my_message );
            
            $theme = WP_CLI::runcommand( 'theme activate ' .$theme_to_install, $options );
            
            $my_message = WP_CLI::colorize( "%GTheme has been activated... " );
            WP_CLI::log( $my_message );

            $my_message = WP_CLI::colorize( "%BStep 2 activating plugins... " );
            WP_CLI::log( $my_message );

            $plugins_to_install = array ('all-in-one-seo-pack', 'really-simple-ssl', 'updraftplus');
            
            foreach($plugins_to_install as $plugin):
                $my_message = WP_CLI::colorize( '%GInstalling ' .$plugin. ' ....' );
                WP_CLI::log( $my_message );
                
                $plugin_install = WP_CLI::runcommand( 'plugin install ' .$plugin, $options );
                $plugin_activate = WP_CLI::runcommand( 'plugin activate ' .$plugin, $options );
                
                $my_message = WP_CLI::colorize( '%GSuccesss installing ' .$plugin. ' ....' );
                WP_CLI::log( $my_message );

            endforeach;
            

        }
        

        public function small_roll() {
            $this->roller_boy();
            WP_CLI::success('We are done. The magic has been done now!!!');
        
        }

        public function big_roll($args, $assoc_args ) {

            $this->roller_boy();

            $my_message = WP_CLI::colorize( "%YSo you want to whole stuff eh???? %n " );
            WP_CLI::log( $my_message );

            $post_type_to_add = WP_CLI\Utils\get_flag_value($assoc_args, 'cpt', false);
                
            $my_message = WP_CLI::colorize( "%BStep 3 creating custom post types... " );
            WP_CLI::log( $my_message );


            $options = array(
                'return'     => true,   // Return 'STDOUT'; use 'all' for full object.
                'launch'     => false,  // Reuse the current process.
                'exit_error' => true,   // Halt script execution on error.
            );

            $label_cpt = ucfirst($post_type_to_add)."s";

            $post_register_it = WP_CLI::runcommand( 'scaffold post-type ' .$post_type_to_add. ' --label='.$label_cpt. ' --theme=client-theme', $options );

            $my_message = WP_CLI::colorize( "%1Post Type has been created. REMEMBER: You need to declare it inside your theme file! " );
            WP_CLI::log( $my_message );

            $my_message = WP_CLI::colorize( "%BStep 4 creating custom taxonomy... " );
            WP_CLI::log( $my_message );


            //$tax_register_it = WP_CLI::runcommand( 'scaffold taxonomy ' .$taxonmy_to_add. ' --post_types='.$post_type_to_add.' >  papi.php', $options );

            //$my_message = WP_CLI::colorize( "%1Taxonomy has been created. REMEMBER: You need to declare it inside your theme file! " );
            //WP_CLI::log( $my_message );

            $my_message = WP_CLI::colorize( "%0Looks like that is that...." );
            WP_CLI::log( $my_message );

            WP_CLI::success('We are done. Thank you for atending this webinar!!!');

            // $post_add = WP_CLI::runcommand( 'plugin install ' .$plugin, $options );

            // give output
            //wp my command the_child_theme_name --cpt=val1 --txv=val1
            // WP_CLI::success( 'hello from bigroll !' );
            // WP_CLI::log( 'You said you wanted some' .$args["assoc_args"]. '?' );
            //wp firx exposed_function_with_args arg1 42 --make-tacos=veggie --supersize --fave-dog-name='Trixie the Mutt'

        }

    }

    WP_CLI::add_command( 'rolling', 'BallRollingPluginWPCLI' );

}
