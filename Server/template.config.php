<?php
	/**
	 * @file config.php
	 * @Author Michal Mareš
	 * @date March, 2017
	 * @brief Contains all the user-configurable variables.
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

		/// Specify main and backup SMTP servers. (Most of the time, one is enough. In that case, leave it as "*****.***;".)
		const mailHost = '*****.***; *****.***';
		/// SMTP username. From this address notifications will be sent.
		const mailUsername = 'usr@domain.tld';
		/// SMTP password.
		const mailPassword = 'pass';
		/// Ardularm address (has to be the same as mailbox name, DO NOT CHANGE).
		const mailSetFromAddress = self::mailUsername;
		/// Sender's name (can be changed).
		const mailSetFromName = 'Ardularm';
		/// Recipient's address (owner). This is where the notifications will be sent.
		const mailaddAddressAddress = 'to@domain.tld';
		/// Recipient's name.
		const mailaddAddressName = 'name';
	}
?>
