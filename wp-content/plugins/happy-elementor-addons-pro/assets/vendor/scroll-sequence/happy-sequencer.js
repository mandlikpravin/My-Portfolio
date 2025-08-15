/** jQuery-Sequencer (Improved Version)
 *
 * This is an enhanced version of the original jQuery-Sequencer library.
 * The original library was created by Thomas Låver and can be found at:
 * https://github.com/skruf/jQuery-sequencer
 *
 * Original Author: Thomas Låver
 * Original Website: http://www.laaver.com
 *
 * Version: 2.0.0 (Improved)
 * Requires: jQuery 1.6+
 *
 * Enhancements and modifications have been made to improve functionality
 * and usability while retaining the core features and inspiration from
 * the original work.
 *
 * Credit: Full credit is given to the original author for the foundational
 * work and inspiration behind this library.
 */

(function ($) {
	$.fn.HappySequencer = function (options, cb) {
		var self = this,
			paths = [],
			images = [], // Array to store preloaded Image objects
			load = 0,
			canvas,
			context,
			sectionHeight,
			windowHeight,
			currentScroll,
			percentageScroll,
			index = 0;

		if (options.path) {
			/* this code is not used */
			// Remove any trailing slash from options.path if present
			if (options.path.substr(-1) === "/") {
				options.path = options.path.substr(0, options.path.length - 1);
			}

			// Generate the file paths for each image in the sequence
			for (var i = 0; i <= options.count; i++) {
				paths.push(options.path + "/" + i + "." + options.ext);
			}
		}

		if (options.links) {
			paths = options.links;
		}

		// Ensure the target element is a canvas.
		// If not, we create a canvas element inside the current element.
		if (!this.is("canvas")) {
			canvas = document.createElement("canvas");
			canvas.className = "jquery-sequencer-canvas";
			canvas.style.width = $(self).outerWidth() + "px";
			canvas.style.height = $(self).outerHeight() + "px";
			$(self).append(canvas);
		} else {
			canvas = this.get(0);
		}

		// Function to update canvas dimensions based on the container's size
		function resizeCanvas(canvas) {
			const ctx = canvas.getContext("2d");
			// const dpr = window.devicePixelRatio || 1;
			const dpr = 1;

			const width = $(self).outerWidth();
			const height = $(self).outerHeight();

			// Set the canvas resolution to match the device pixel ratio
			canvas.width = width * dpr;
			canvas.height = height * dpr;

			// Set the canvas display size via CSS
			canvas.style.width = width + "px";
			canvas.style.height = height + "px";

			// Scale the context so everything is crisp
			ctx.scale(dpr, dpr);
		}

		// Initial canvas sizing and responsive update on window resize.
		resizeCanvas(canvas);
		$(window).resize(function () {
			resizeCanvas(canvas);
			drawFrame(index, canvas); // Redraw the current frame after resizing
		});

		// Preload each image. Once all images are loaded, call the provided callback.
		$.each(paths, function (i, src) {
			var img = new Image();
			img.onload = function () {
				load++;
				images[i] = img;
				if (load === paths.length) {
					if (typeof cb === "function") {
						cb();
					}
					drawFrame(0, canvas); // Draw the first image initially
				}
			};
			img.onerror = function () {
				console.error("Failed to load image:", src);
			};
			img.src = src;
		});

		// Function to draw the frame specified by frameIndex on the canvas
		function drawFrame(frameIndex, canvas) {
			const context = canvas.getContext("2d");
			const image = images[frameIndex];

			if (image && context) {
				context.clearRect(0, 0, canvas.width, canvas.height);
				let scale = Math.max(
						canvas.width / image.width,
						canvas.height / image.height
					),
					cWidth = canvas.width / 2 - (image.width / 2) * scale,
					cHeight = canvas.height / 2 - (image.height / 2) * scale;
				context.drawImage(
					image,
					Math.round(cWidth),
					Math.round(cHeight),
					Math.ceil(image.width * scale),
					Math.ceil(image.height * scale)
				);
			}
		}

		$(window).on("scroll", onsScroll);
		function onsScroll() {
			const scrollTop = $(window).scrollTop();
			const windowHeight = $(window).height();

			const $sec = $(self).parent();
			const secTop = $sec.offset().top;
			const secHeight = $sec.outerHeight();
			const secBot = secTop + secHeight;

			// 1px-visibility test
			if (!(secBot > scrollTop && secTop < scrollTop + windowHeight)) {
				return;
			}

			// How far we've scrolled *into* the section:
			// 0px when top of section hits top of viewport,
			// maxScroll when bottom of section hits bottom of viewport.
			const maxScroll = secHeight - windowHeight;
			let offset = scrollTop - secTop;
			offset = Math.min(Math.max(offset, 0), maxScroll);

			// percentage [0…1]
			const pct = maxScroll > 0 ? offset / maxScroll : 0;

			// map to a frame index [0…images.length-1]
			const idx = Math.floor(pct * (images.length - 1));

			drawFrame(idx, canvas);
		}

		return this;
	};
})(jQuery);
