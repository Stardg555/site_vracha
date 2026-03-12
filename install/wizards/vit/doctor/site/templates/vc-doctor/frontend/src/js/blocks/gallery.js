import Swiper from 'swiper'

window.addEventListener('DOMContentLoaded', async () => {
	const galleries = document.querySelectorAll('.vc-gallery')
	if (!galleries.length) return

	const init = gallery => {
		const photos = gallery.querySelectorAll('.vc-gallery__photo')
		let carouselSlider = null
		let fullScreenSlider = null
		let mainSlider = null
		const sliders = gallery.querySelector('.vc-gallery__sliders')
		const slidersActiveCls = 'vc-gallery__sliders--active'
		const fullscreenSliderActiveCls = 'vc-gallery__slider--active'
		const carouselSliderActiveCls = 'vc-gallery__carousel--active'
		const isHorizontal = gallery.classList.contains('vc-gallery--horizontal')

		// const mainGallery = document.querySelector('.vc-main-gallery')
		const activeClass = 'vc-gallery__arrow--active'

		sliders.addEventListener('click', ({target}) => {
			if (!sliders.classList.contains(slidersActiveCls)) return
			const isFullscreenSlider = target.closest('.vc-gallery__slider')
			const isCarouselSlider = target.closest('.vc-gallery__carousel')
			if (!isFullscreenSlider && !isCarouselSlider) {
				sliders.classList.remove(slidersActiveCls)
				fullScreenSlider.el.classList.remove(fullscreenSliderActiveCls)
			}
		})

		const hideEl = el => {
			if (!el) return
			el.classList.remove(activeClass)
			// el.style.opacity = '0'
			// el.style.pointerEvents = 'none'
		}

		const showEl = el => {
			if (!el) return
			el.classList.add(activeClass)
			// el.style.opacity = '1'
			// el.style.pointerEvents = ''
		}

		const checkArrows = slider => {
			const { el, isBeginning, isEnd, } = slider
			const container = el.closest('.vc-gallery').querySelector('.vc-gallery__title-slider-nav')

			const leftBtn = !!container ?
				container.querySelector('.vc-gallery__title-arrow--left') :
				el.querySelector('.vc-gallery__main-slider-arrow--left')

			const rightBtn = !!container ?
				container.querySelector('.vc-gallery__title-arrow--right') :
				el.querySelector('.vc-gallery__main-slider-arrow--right')

			isEnd && hideEl(rightBtn)
			!isEnd && showEl(rightBtn)

			isBeginning && hideEl(leftBtn)
			!isBeginning && showEl(leftBtn)
		}

		// main slider
		const galleryMainSlider = gallery.querySelector('.vc-gallery__main-slider')

		const onMainSliderInit = ({wrapper, slider}) => {
			mainSlider = slider
			const slidesCount = slider.slides.length
			wrapper.style.opacity = '1'
			//
			const container = wrapper.closest('.vc-gallery').querySelector('.vc-gallery__title-slider-nav')

			const leftBtn = !!container ?
				container.querySelector('.vc-gallery__title-arrow--left') :
				wrapper.querySelector('.vc-gallery__main-slider-arrow--left')

			const rightBtn = !!container ?
				container.querySelector('.vc-gallery__title-arrow--right') :
				wrapper.querySelector('.vc-gallery__main-slider-arrow--right')

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
				// checkArrows(slider)
			})

			!!rightBtn &&
			rightBtn.addEventListener('click', () => {
				slider.slideNext()
				// checkArrows(slider)
			})

			checkArrows(slider)
		}

		const getMainSliderOptions = wrapper => {
			return {
				spaceBetween: 16,
				slidesPerView: 'auto',
				on: {
					init: slider => {
						onMainSliderInit({
							wrapper,
							slider,
						})
					},
					slideNextTransitionEnd: (slider) => {
						checkArrows(slider)
					},
					slidePrevTransitionEnd: (slider) => {
						checkArrows(slider)
					},
				},
				breakpoints: {
					500: {
						slidesPerView: isHorizontal ? 'auto' : 2,
						spaceBetween: 16,
						// slidesPerGroup: 2,
					},
					768: {
						slidesPerView: isHorizontal ? 'auto' : 2,
						spaceBetween: 24,
						// slidesPerGroup: 2,
					},
					1024: {
						slidesPerView:  isHorizontal ? 'auto' : 2,
						spaceBetween: isHorizontal ? 48 : 24,
						// slidesPerGroup: 2,
					},
					1279: {
						slidesPerView: isHorizontal ? 'auto' : 'auto',
						// spaceBetween: 66,
						spaceBetween: isHorizontal ? 66 : 24,
						// slidesPerGroup: 2,
					},
				},
			}
		}

		// const mainSliderContainer = document.querySelector('.vc-gallery__main-slider')
		// if (!sliderElement) return

		new Swiper(galleryMainSlider, getMainSliderOptions(galleryMainSlider))

		// carousel slider
		const carousel = gallery.querySelector('.vc-gallery__carousel')

		const onCarouselInit = ({wrapper, slider}) => {
			const innerWrapper = wrapper.querySelector('.vc-gallery__carousel-wrapper')
			let innerWidth = 0
			slider.slides.forEach((slide) => innerWidth += slide.swiperSlideSize)
			if (innerWidth < slider.width) {
				innerWrapper.style.justifyContent = 'center'
			}
			carouselSlider = slider
			const slidesCount = slider.slides.length

			// close wrapper
			wrapper.addEventListener('click', ({ target }) => {
				const item = target.closest('.vc-gallery__carousel-slide-img')
				if (!item) {
					sliders.classList.remove(slidersActiveCls)
					fullScreenSlider.el.classList.remove(fullscreenSliderActiveCls)
				}
			})

			// change carousel item
			wrapper.addEventListener('click', (e) => {
				const { target } = e
				const clickedOnSlideEl = target.closest('.vc-gallery__carousel-slide')
				const slideRealIndex = [...slider.slides].indexOf(clickedOnSlideEl)
				if (!!fullScreenSlider && slideRealIndex > -1) {
					!!fullScreenSlider && fullScreenSlider.slideTo(slideRealIndex, 500, false)
					!!fullScreenSlider && mainSlider.slideTo(slideRealIndex, 500, false)
					!!fullScreenSlider.el && fullScreenSlider.el.classList.add(fullscreenSliderActiveCls)
					checkSliderArrows(fullScreenSlider)
					checkArrows(mainSlider)
				}
			})

			// const leftBtn = wrapper.querySelector('.vc-gallery__carousel-arrow--left')
			// const rightBtn = wrapper.querySelector(
			// 	'.vc-gallery__carousel-arrow--right',
			// )

			// if (
			// 	(window.innerWidth > 1023 && slidesCount < 5) ||
			// 	(window.innerWidth > 767 && slidesCount < 4) ||
			// 	(window.innerWidth > 499 && slidesCount < 3) ||
			// 	(window.innerWidth < 500 && slidesCount < 2)
			// ) {
			// 	;[leftBtn, rightBtn].forEach(el => hideEl(el))
			// 	return
			// }

			// !!leftBtn &&
			// 	leftBtn.addEventListener('click', () => {
			// 		carouselSlider.slidePrev()
			// 	})
			//
			// !!rightBtn &&
			// 	rightBtn.addEventListener('click', () => {
			// 		carouselSlider.slideNext()
			// 	})
		}

		const getCarouselOptions = wrapper => {
			return {
				spaceBetween: 8,
				slidesPerView: 3,
				freeMode: true,
				watchSlidesProgress: true,
				breakpoints: {
					500: {
						slidesPerView: 4,
					},
					768: {
						slidesPerView: 5,
						spaceBetween: 12,
					},
					1024: {
						slidesPerView: 6,
					},
					1256: {
						slidesPerView: 7,
					},
					1490: {
						slidesPerView: 8,
					}
				},
				on: {
					init: slider => {
						onCarouselInit({
							wrapper,
							slider,
						})
					},
					// slideNextTransitionEnd: (slider) => {
					// 	checkCarouselArrows(slider)
					// },
					// slidePrevTransitionEnd: (slider) => {
					// 	checkCarouselArrows(slider)
					// },
				},
			}
		}

		new Swiper(carousel, getCarouselOptions(carousel))

		// fullscreen slider
		const slider = gallery.querySelector('.vc-gallery__slider')

		const onClickPhoto = (photo) => {
			photo.addEventListener('click', ({target}) => {
				const clickedOnSlideEl = target.closest('.vc-gallery__photo')
				const slideRealIndex = [...photos].indexOf(clickedOnSlideEl)
				if (!!fullScreenSlider && slideRealIndex > -1) {
					if (!!fullScreenSlider) {
						fullScreenSlider.slideTo(slideRealIndex, 0, false)
						carouselSlider.slideTo(slideRealIndex, 0, false)
						fullScreenSlider.el.classList.add(fullscreenSliderActiveCls)
					}
					sliders.classList.add(slidersActiveCls)
					checkSliderArrows(fullScreenSlider)
				}
			})
		}

		photos.forEach(p => onClickPhoto(p))

		const checkSliderArrows = slider => {
			const { el, isBeginning, isEnd } = slider
			// console.log(el, isBeginning, isEnd)
			const leftBtn = el.querySelector('.vc-gallery__slider-arrow--left')
			const rightBtn = el.querySelector('.vc-gallery__slider-arrow--right')

			isEnd && hideEl(rightBtn)
			!isEnd && showEl(rightBtn)

			isBeginning && hideEl(leftBtn)
			!isBeginning && showEl(leftBtn)
		}

		const onSliderInit = ({wrapper, slider}) => {
			fullScreenSlider = slider
			const slidesCount = slider.slides.length

			const leftBtn = wrapper.querySelector('.vc-gallery__slider-arrow--left')
			const rightBtn = wrapper.querySelector('.vc-gallery__slider-arrow--right')

			if (slidesCount < 2) {
				;[leftBtn, rightBtn].forEach(el => hideEl(el))
				return
			}

			// synchronize fullscreen and carousel slides
			const synchronizeSliders = () => {
				const activeIndex = fullScreenSlider.activeIndex
				const carouselActiveIndex = carouselSlider.activeIndex
				const isVisibleSlide = carouselSlider.slides[activeIndex].classList.contains('swiper-slide-visible')
				!isVisibleSlide && carouselSlider.slideTo(activeIndex, 500, false)
			}

			!!leftBtn &&
				leftBtn.addEventListener('click', () => {
					slider.slidePrev()
					synchronizeSliders()
					// carouselSlider.slidePrev()
				})

			!!rightBtn &&
				rightBtn.addEventListener('click', () => {
					slider.slideNext()
					synchronizeSliders()
					// carouselSlider.slideNext()
				})

			checkSliderArrows(slider)

			// close full screen mode
			wrapper.addEventListener('click', ({ target }) => {
				const isCloseBtn = target.closest('.vc-gallery__slider-close')
				const isSlide = target.closest('.vc-gallery__slider-slide-img')
				const isSlideArrow = target.closest('.vc-gallery__slider-arrow')
				if (isCloseBtn || (!isSlide && !isSlideArrow)) {
					sliders.classList.remove(slidersActiveCls)
					fullScreenSlider.el.classList.remove(fullscreenSliderActiveCls)
				}
			})
			// wrapper.addEventListener('click', ({ target }) => {
			// 	const isCloseBtn = target.closest('.vc-gallery__slider-close')
			// 	const isSlideContent = target.closest('.vc-gallery__slider-slide-content')
			// 	const isSlideArrow = target.closest('.vc-gallery__slider-arrow')
			// 	if (isCloseBtn || (!isSlideContent && !isSlideArrow))  {
			// 		wrapper.classList.remove(fullscreenSliderActiveCls)
			// 		carousel.classList.remove(carouselSliderActiveCls)
			// 	}
			// })
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
						!!carouselSlider && carouselSlider.slideNext()
						!!mainSlider && mainSlider.slideNext()
					},
					slidePrevTransitionEnd: (slider) => {
						checkSliderArrows(slider)
						!!carouselSlider && carouselSlider.slidePrev()
						!!mainSlider && mainSlider.slidePrev()
					},
				},
			}
		}

		new Swiper(slider, getSliderOptions(slider))

	}

	galleries.forEach(g => init(g))
})
