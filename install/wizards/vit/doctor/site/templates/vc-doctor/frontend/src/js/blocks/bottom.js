window.addEventListener('DOMContentLoaded', () => {
	let isAnimating = false
	const sec = '0.3s'

	// events
	const bottomOpen = new Event('bottomOpen')
	const bottomClose = new Event('bottomClose')

	// bottom container open / close animations
	const closeBottom = bar => {
		isAnimating = true
		bar.style.transition = sec
		bar.style.transform = 'translateY(calc(100% + 40px))'
		document.body.classList.remove('is-overlay')
		setTimeout(() => {
			isAnimating = false
			window.dispatchEvent(bottomClose)
		}, 500)
	}

	const activateBottom = type => {
		if (isAnimating) return
		const thisBottom = document.querySelector(
			'.js-bottom[data-type=' + type + ']',
		)
		if (!thisBottom) {
			console.log('error: bottom type ' + type + ' not found')
			return
		}
		isAnimating = true
		window.dispatchEvent(bottomOpen)
		thisBottom.style.transition = sec
		thisBottom.style.transform = 'translateY(0)'
		document.body.classList.add('is-overlay')
		setTimeout(() => {
			thisBottom.style.transition = '0s'
			isAnimating = false
		}, 500)
	}
	window.activateBottom = activateBottom

	document.body.addEventListener('click', e => {
		if (e.target.classList.contains('is-overlay')) {
			const bottom = document.querySelectorAll('.js-bottom')
			bottom.forEach(bar => {
				closeBottom(bar)
			})
		}
	})

	const init = () => {
		const bottom = document.querySelectorAll('.js-bottom')
		bottom.forEach(bar => {
			const init = bar.getAttribute('data-init')
			if (!!init) return
			bar.setAttribute('data-init', true)
			let touchX = 0
			let touchDelta = 0
			let isScrolling = false
			bar.addEventListener('touchstart', e => {
				touchX = e.touches[0].screenY
			})
			bar.addEventListener('touchmove', e => {
				let scrollPos = bar.querySelector('.vc-bottom__content').scrollTop
				let isContentScrolling =
					bar.getBoundingClientRect().y < e.touches[0].clientY

				if (scrollPos > 0 && isContentScrolling) {
					isScrolling = true
					return
				} else {
					setTimeout(() => {
						isScrolling = false
					}, 500)
				}
				if (!isScrolling) {
					touchDelta = e.touches[0].screenY - touchX
				}
				if (touchDelta > 0) {
					bar.style.transform = 'translateY(' + touchDelta + 'px)'
				}
			})
			bar.addEventListener('touchend', () => {
				if (touchDelta > 50) {
					closeBottom(bar)
				} else {
					bar.style.transform = 'translateY(0px)'
				}
				touchDelta = 0
				touchX = 0
				// bar.style.transform = 'translateY(0px)'
			})
		})

		const bottomBtns = document.querySelectorAll('.js-bottom-activate')
		bottomBtns.forEach(btn => {
			const init = btn.getAttribute('data-init')
			if (!!init) return
			btn.setAttribute('data-init', true)
			btn.addEventListener('click', () => {
				const type = btn.getAttribute('data-type')
				activateBottom(type)
			})
		})

	}
	init()
	window.addEventListener('ajax-loaded', init)
})
