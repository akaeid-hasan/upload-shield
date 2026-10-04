(function ($) {
	'use strict';

	$(document).on('click', '.ush-support-popup__close', function () {
		var $card = $('#upload-shield-support-card');
		$card.addClass('is-dismissing');

		$.post(UploadShieldAdmin.ajaxUrl, {
			action: 'upload_shield_dismiss_branding',
			nonce: UploadShieldAdmin.dismissNonce
		}).always(function () {
			window.setTimeout(function () {
				$card.remove();
			}, 220);
		});
	});
})(jQuery);
