<?php
/*
 * Plugin Name: WooCommerce Subscriptions - Add Pay Action
 * Plugin URI: https://github.com/Prospress/woocommerce-subscriptions-add-pay-action/
 * Description: Add the Pay button to the actions displayed against a subscription pending payment on the My Account > View Subscription page.
 * Author: Prospress Inc.
 * Author URI: https://prospress.com/
 * License: GPLv3
 * Version: 1.0.0
 * Requires at least: 4.0
 * Tested up to: 4.8
 *
 * GitHub Plugin URI: Prospress/woocommerce-subscriptions-add-pay-action
 * GitHub Branch: master
 *
 * Copyright 2019 Prospress, Inc.  (email : freedoms@prospress.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package		WooCommerce Subscriptions - Add Pay Action
 * @author		Prospress Inc.
 * @since		1.0
 */

require_once( 'includes/class-pp-dependencies.php' );

if ( false === PP_Dependencies::is_woocommerce_active( '3.0' ) ) {
	PP_Dependencies::enqueue_admin_notice( 'WooCommerce Subscriptions - Add Pay Action', 'WooCommerce', '3.0' );
	return;
}

if ( false === PP_Dependencies::is_subscriptions_active( '2.1' ) ) {
	PP_Dependencies::enqueue_admin_notice( 'WooCommerce Subscriptions - Add Pay Action', 'WooCommerce Subscriptions', '2.1' );
	return;
}

function wcsapa_change_payment_method_button( $actions, $subscription ) {

	if ( $subscription->needs_payment() ) {

		$order = $subscription->get_last_order( 'all', 'any' );

		if ( $order ) {
			$actions['pay'] = array(
				'url'  => $order->get_checkout_payment_url(),
				'name' => esc_html_x( 'Pay', 'pay for a subscription', 'woocommerce-subscriptions' ),
			);
		}
	}

	return $actions;
}
add_filter( 'wcs_view_subscription_actions', 'wcsapa_change_payment_method_button', 10, 2 );
