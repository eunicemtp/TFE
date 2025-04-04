<?php
/**
 * Notify merchant that Multi-Currency is available.
 *
 * @package WooCommerce\Payments\MultiCurrency
 */

namespace WCPay\MultiCurrency\Notes;

use Automattic\WooCommerce\Admin\Notes\Note;
use Automattic\WooCommerce\Admin\Notes\NoteTraits;
use WCPay\MultiCurrency\Interfaces\MultiCurrencyAccountInterface;

defined( 'ABSPATH' ) || exit;

/**
 * Class NoteMultiCurrencyAvailable
 */
class NoteMultiCurrencyAvailable {
	use NoteTraits;

	/**
	 * Name of the note for use in the database.
	 */
	const NOTE_NAME = 'wc-payments-notes-multi-currency-available';

	/**
	 * Url to start the setup process. Now redirects to the wizard page.
	 */
	// TODO: Proper url needed for setup process.
	const NOTE_SETUP_URL = 'admin.php?page=wc-admin&path=/payments/multi-currency-setup';

	/**
	 * The account service instance.
	 *
	 * @var MultiCurrencyAccountInterface
	 */
	private static $account;

	/**
	 * Get the note.
	 */
	public static function get_note() {
		$note = new Note();

		$note->set_title( __( 'Sell worldwide in multiple currencies', 'woocommerce-payments' ) );
		$note->set_content( __( 'Boost your international sales by allowing your customers to shop and pay in their local currency.', 'woocommerce-payments' ) );
		$note->set_content_data( (object) [] );
		$note->set_type( Note::E_WC_ADMIN_NOTE_INFORMATIONAL );
		$note->set_name( self::NOTE_NAME );
		$note->set_source( 'woocommerce-payments' );
		$note->add_action(
			self::NOTE_NAME,
			__( 'Set up now', 'woocommerce-payments' ),
			self::NOTE_SETUP_URL,
			'unactioned',
			true
		);

		return $note;
	}

	/**
	 * Add the note if it passes predefined conditions.
	 */
	public static function possibly_add_note() {
		// Don't add the note if the merchant didn't create a WCPay account yet.
		if ( is_null( self::$account ) || ! self::$account->is_provider_connected() ) {
			return;
		}

		if ( ! self::can_be_added() ) {
			return;
		}

		$note = self::get_note();
		$note->save();
	}

	/**
	 * Sets the account service instance reference on the class.
	 *
	 * @param MultiCurrencyAccountInterface $account account service instance.
	 */
	public static function set_account( MultiCurrencyAccountInterface $account ) {
		self::$account = $account;
	}
}
