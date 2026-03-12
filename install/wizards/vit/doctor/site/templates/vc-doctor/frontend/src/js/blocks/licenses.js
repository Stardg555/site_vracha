import Swiper from 'swiper'

window.addEventListener('DOMContentLoaded', async () => {
	const galleries = document.querySelectorAll('.vc-licenses')
	if (!galleries.length) return

	const init = licenses => {
		let mainSlider = null
		let fullScreenSlider = null
		const fullscreenSliderActiveCls = 'vc-licenses__slider--active'

		const hideEl = el => {
			if (!el) return
			el.style.opacity = '0'
			el.style.pointerEvents = 'none'
		}

		const showEl = el => {
			if (!el) return
			el.style.opacity = '1'
			el.style.pointerEvents = ''
		}

		const checkCarouselArrows = slider => {
			const { el, isBeginning, isEnd, } = slider
			const leftBtn = el.querySelector('.vc-licenses__carousel-arrow--left')
			const rightBtn = el.querySelector('.vc-licenses__carousel-arrow--right')

			isEnd && hideEl(rightBtn)
			!isEnd && showEl(rightBtn)

			isBeginning && hideEl(leftBtn)
			!isBeginning && showEl(leftBtn)
		}

		// carousel main slider
		const carousel = licenses.querySelector('.vc-licenses__carousel')

		const onCarouselInit = ({wrapper, slider}) => {
			mainSlider = slider
			const slidesCount = slider.slides.length

			wrapper.style.opacity = '1'

			// open full screen slider
			wrapper.addEventListener('click', (e) => {
				const { target } = e
				const clickedOnSlideEl = target.closest('.vc-licenses__carousel-slide')
				const slideRealIndex = [...slider.slides].indexOf(clickedOnSlideEl)
				if (!!fullScreenSlider && slideRealIndex > -1) {
					!!fullScreenSlider && fullScreenSlider.slideTo(slideRealIndex, 0, false)
					!!fullScreenSlider.el && fullScreenSlider.el.classList.add(fullscreenSliderActiveCls)
					checkSliderArrows(fullScreenSlider)
				}
			})

			checkCarouselArrows(slider)

			const leftBtn = wrapper.querySelector('.vc-licenses__carousel-arrow--left')
			const rightBtn = wrapper.querySelector(
				'.vc-licenses__carousel-arrow--right',
			)

			// if (
			// 	(window.innerWidth > 1023 && slidesCount < 5) ||
			// 	(window.innerWidth > 767 && slidesCount < 4) ||
			// 	(window.innerWidth > 499 && slidesCount < 3) ||
			// 	(window.innerWidth < 500 && slidesCount < 2)
			// ) {
			// 	;[leftBtn, rightBtn].forEach(el => hideEl(el))
			// 	return
			// }

			!!leftBtn &&
				leftBtn.addEventListener('click', () => {
					slider.slidePrev()
				})

			!!rightBtn &&
				rightBtn.addEventListener('click', () => {
					slider.slideNext()
				})

		}

		const getCarouselOptions = wrapper => {

			return {
				spaceBetween: 16,
				slidesPerView: 1,
				breakpoints: {
					500: {
						slidesPerView: 2,
					},
					768: {
						slidesPerView: 3,
					},
					1024: {
						slidesPerView: 4,
						spaceBetween: 24,
					},
				},
				on: {
					init: slider => {
						onCarouselInit({
							wrapper,
							slider,
						})
					},
					slideNextTransitionEnd: (slider) => {
						checkCarouselArrows(slider)
					},
					slidePrevTransitionEnd: (slider) => {
						checkCarouselArrows(slider)
					},
				},
			}
		}

		new Swiper(carousel, getCarouselOptions(carousel))

		// fullscreen slider
		const slider = licenses.querySelector('.vc-licenses__slider')
		const checkSliderArrows = slider => {
			const { el, isBeginning, isEnd, } = slider
			const leftBtn = el.querySelector('.vc-licenses__slider-arrow--left')
			const rightBtn = el.querySelector('.vc-licenses__slider-arrow--right')

			isEnd && hideEl(rightBtn)
			!isEnd && showEl(rightBtn)

			isBeginning && hideEl(leftBtn)
			!isBeginning && showEl(leftBtn)
		}

		const onSliderInit = ({wrapper, slider}) => {
			fullScreenSlider = slider
			const slidesCount = slider.slides.length

			const leftBtn = wrapper.querySelector('.vc-licenses__slider-arrow--left')
			const rightBtn = wrapper.querySelector('.vc-licenses__slider-arrow--right')

			if (slidesCount < 1) {
				;[leftBtn, rightBtn].forEach(el => hideEl(el))
				return
			}

			!!leftBtn &&
				leftBtn.addEventListener('click', () => {
					slider.slidePrev()
				})

			!!rightBtn &&
				rightBtn.addEventListener('click', () => {
					slider.slideNext()
				})

			checkSliderArrows(slider)

			// close full screen mode
			wrapper.addEventListener('click', ({ target }) => {
				const isCloseBtn = target.closest('.vc-licenses__slider-close')
				const isSlideContent = target.closest('.vc-licenses__slider-slide-content')
				const isSlideArrow = target.closest('.vc-licenses__slider-arrow')
				if (isCloseBtn || (!isSlideContent && !isSlideArrow)) wrapper.classList.remove(fullscreenSliderActiveCls)
			})
		}

		const getSliderOptions = wrapper => {
			return {
				spaceBetween: 0,
				slidesPerView: 1,
				on: {
					init: slider => {
						onSliderInit({
							wrapper,
							slider,
						})
					},
					slideNextTransitionEnd: (slider) => {
						checkSliderArrows(slider)
						!!mainSlider && mainSlider.slideNext()
					},
					slidePrevTransitionEnd: (slider) => {
						checkSliderArrows(slider)
						!!mainSlider && mainSlider.slidePrev()
					},
				},
			}
		}

		new Swiper(slider, getSliderOptions(slider))
	}

	galleries.forEach(l => init(l))
})
