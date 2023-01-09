;(function($) {
	'use strict';

	// CLASS DEFINITION
	// ================

	var DataKey = 'ch.slugInput';
	var Default = {
		separator: "-",
		targetId: "title",
		disabled: false
	};

	// More charmap in https://github.com/pid/speakingurl
	// Russian https://en.wikipedia.org/wiki/Romanization_of_Russian
	// ICAO
	var charMap = {
		'а': 'a',	'б': 'b',	'в': 'v',	'г': 'g',	'д': 'd',	'е': 'e',	'ё': 'yo',	'ж': 'zh',	'з': 'z',	'и': 'i',	'й': 'i',
		'к': 'k',	'л': 'l',	'м': 'm',	'н': 'n',	'о': 'o',	'п': 'p',	'р': 'r',	'с': 's',	'т': 't',	'у': 'u',	'ф': 'f',
		'х': 'kh',	'ц': 'c',	'ч': 'ch',	'ш': 'sh',	'щ': 'sh',	'ъ': '',	'ы': 'y',	'ь': '',	'э': 'e',	'ю': 'yu',	'я': 'ya',
		'А': 'A',	'Б': 'B',	'В': 'V',	'Г': 'G',	'Д': 'D',	'Е': 'E',	'Ё': 'Yo',	'Ж': 'Zh',	'З': 'Z',	'И': 'I',	'Й': 'I',
		'К': 'K',	'Л': 'L',	'М': 'M',	'Н': 'N',	'О': 'O',	'П': 'P',	'Р': 'R',	'С': 'S',	'Т': 'T',	'У': 'U',	'Ф': 'F',
		'Х': 'Kh',	'Ц': 'C',	'Ч': 'Ch',	'Ш': 'Sh',	'Щ': 'Sh',	'Ъ': '',	'Ы': 'Y',	'Ь': '',	'Э': 'E',	'Ю': 'Yu',	'Я': 'Ya',

		// Ukranian
		'Є': 'Ye',	'І': 'I',	'Ї': 'Yi',	'Ґ': 'G',	'є': 'ye',	'і': 'i',	'ї': 'yi',	'ґ': 'g',

		// symbols
		'“': '"',	'”': '"',	'‘': "'",	'’': "'",	'∂': 'd',	'ƒ': 'f',	'…': '...',	'˚': 'o',	'º': 'o',	'ª': 'a',	'•': '*',
		'၊': ',',	'။': '.',	'©': '(C)',	'œ': 'oe',	'Œ': 'OE',	'®': '(R)',	'†': '+',	'℠': '(SM)',	'™': '(TM)',

		// currency
		'$': 'USD',	'€': 'EUR',	'₢': 'BRN',	'₣': 'FRF',	'£': 'GBP',	'₤': 'ITL',	'₦': 'NGN',	'₧': 'ESP',	'₩': 'KRW',	'₪': 'ILS',	'₫': 'VND',
		'₭': 'LAK',	'₮': 'MNT',	'₯': 'GRD',	'₱': 'ARS',	'₲': 'PYG',	'₳': 'ARA',	'₴': 'UAH',	'₵': 'GHS',	'¥': 'CNY',	'元': 'CNY',	'円': 'YEN',
		'﷼': 'IRR',	'₠': 'EWE',	'฿': 'THB',	'₨': 'INR',	'₹': 'INR',	'₰': 'PF',	'₺': 'TRY',	'؋': 'AFN',	'₼': 'AZN',	'៛': 'KHR',	'₡': 'CRC',
		'₸': 'KZT',	'₽': 'RUB',	'₾': 'GEL',	'лв': 'BGN',	'¢': 'cent',	'ден': 'MKD',	'zł': 'PLN'
	};

	function slug(input, s) {
		return input
			.replace(/(^\s+|\s+$)/g, '')
			.split('').map(function (ch) {
				return (typeof charMap[ch] != 'undefined') ? charMap[ch] : ch;
			}).join("")
			.toLowerCase()
			.replace(/\s+/g, s)
			.replace(new RegExp('[^\\w\\' + s + ']+', 'g'), s)
			.replace(new RegExp('\\' + s + '+', 'g'), s)
			.replace(new RegExp('(^\\' + s + '+|\\' + s + '+$)', 'g'), '');
	}

	var SlugInput = function (input, options) {
		this.input = input;
		this.options = options;
		this.init();
	};

	SlugInput.prototype.init = function () {
		if (this.options.disabled) {
			this.input.prop('disabled', true);
		}
		if (this.options.disabled || !this.input.val().length) {
			if (!this.options.disabled) {
				this.input.on("input", function (e) {
					$(this).data("is-type", true);
				});
			}
			var $this = this;
			$("#" + this.options.targetId).on("input", function (e) {
				if (!$this.input.data("is-type")) {
					$this.input.val(slug($(this).val(), $this.options.separator));
				}
			});
		}
	};

	// PLUGIN DEFINITION
	// =================

	function Plugin(option) {
		return this.each(function () {
			var $this = $(this);
			var data = $this.data(DataKey);

			if (!data) {
				var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option);
				$this.data(DataKey, (data = new SlugInput($this, options)));
			}
			if (typeof option == 'string') {
				data[option]();
			}
		});
	}

	var old = $.fn.chSlugInput;

	$.fn.chSlugInput = Plugin;
	$.fn.chSlugInput.Constructor = SlugInput;

	// NO CONFLICT
	// ===========

	$.fn.chSlugInput.noConflict = function () {
		$.fn.chSlugInput = old;
		return this
	};

})(jQuery);
