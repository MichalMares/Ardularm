<?php
	/**
	 * @file config.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief This script contains all the user-configurable variables.
	 */

	class Config {
		/// Domain.
		const domain = 'ardularm.forgotitsmonday.com';

		// Database type, name, host and port.
		const dsn = '*****:dbname=*****;host=domain.tld:port';
		/// Database login.
		const user = 'login';
		/// Database password.
		const password = 'pass';

		/// Key (has to be the same as in Arduino code).
		const key = 'key';

		/// Mailbox host.
		const mailHost = '*****.***;';
		/// Mailbox name.
		const mailUsername = 'usr@domain.tld';
		/// Mailbox password.
		const mailPassword = 'pass';
		/// Ardularm address (has to be the same as mailbox name, DO NOT CHANGE).
		const mailSetFromAddress = self::mailUsername;
		/// Sender's name (can be changed).
		const mailSetFromName = 'Ardularm';
		/// Owner's address.
		const mailaddAddressAddress = 'to@domain.tld';
		/// Owner's name.
		const mailaddAddressName = 'name';
	}
?>
