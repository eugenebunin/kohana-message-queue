<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Message queue module
 * Works with Bootstrap 2
 * @link: http://twitter.github.com/bootstrap/
 * 
 * 1. To enqueue a message do like this:
 * Message::queue( array('type' => Message::INFO, 'text' => 'Hello from Russia!') );
 * or
 * Message::queue( array('type' => Message::SUCCESS, 'text' => 'Data successfully saved.') );
 * 
 * 2. To print messages use:
 * Message::render();
 * Note: add this in your app template in order to print messages after app is redirected.
 * 
 * Message::queue( array('type' => Message::INFO, 'text' => 'Hello from Russia!') );
 * Message::queue( array('type' => Message::SUCCESS, 'text' => 'Data saved.') );
 * Message::queue( array('type' => Message::ERROR, 'text' => 'Oops, something goes wrong.') );
 * Message::queue( array('type' => Message::NOTIFY, 'text' => 'Just take your attention.') );
 * 
 * @package Kohana/Message
 * @category Modules
 * @author blagorod
 * @link http://bybunin.com
 */
abstract class Message_Core {
	
	const ERROR 	= 'alert alert-error';
	const SUCCESS 	= 'alert alert-success';
	const NOTIFY 	= 'alert alert-notify';
	const INFO 		= 'alert alert-info';

	/**
	 * Setter/Getter message queue.
	 *
	 * Get messages and clear the queue
	 * @param mixed array/null $message
	 * @return mixed Array/NULL
	 */
	public static function queue( array $message = NULL) {
		
		if ( count($message) ) {
			$messages = Session::instance()->get('message.queue');
			$messages[] = $message;
			Session::instance()->set('message.queue', $messages);
		}
		else {
			$messages = Session::instance()->get('message.queue');
			Session::instance()->set('message.queue', null);
			return $messages;
		}
	}
	
	/**
	 * Render the messages and removes them from queue.
	 */
	public static function render( array $config = array() ) {
	
		if ( $messages = Session::instance()->get('message.queue') ) {

			// Empty message queue
			Session::instance()->set('message.queue', null);

			// Load a config view
			$config = Kohana::$config->load('message.default');
			$config_view = isset($config['view']) ? $config['view'] : null;
			
			// Get view and render it
			$view = isset($config['view']) ? $config['view'] : $config_view;
			
			return View::factory( $view )
				->set('messages', $messages)
				->render();
		}
	}
}