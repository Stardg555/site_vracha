import Swiper from 'swiper'

window.addEventListener('DOMContentLoaded', async () => {
    const sliders = document.querySelectorAll('.vc-reviews-slider')
    if (sliders.length === 0) return

    const activeClass = 'vc-reviews-slider__arrow--active'

    let swipers = []

    const hideEl = el => {
    	if (!el) return
        el.classList.remove(activeClass)
    }

    const showEl = el => {
    	if (!el) return
        el.classList.add(activeClass)
    }

    const checkArrows = slider => {
    	const { el, isBeginning, isEnd, } = slider
        const container = el.closest('.vc-section').querySelector('.vc-reviews-slider__title-slider-nav')

        const leftBtn = !!container ?
            container.querySelector('.vc-reviews-slider__title-arrow--left') :
            el.querySelector('.vc-reviews-slider__arrow--left')

        const rightBtn = !!container ?
            container.querySelector('.vc-reviews-slider__title-arrow--right') :
            el.querySelector('.vc-reviews-slider__arrow--right')

    	isEnd && hideEl(rightBtn)
    	!isEnd && showEl(rightBtn)

    	isBeginning && hideEl(leftBtn)
    	!isBeginning && showEl(leftBtn)
    }

    const onSliderInit = ({wrapper, slider}) => {
        swipers.push(slider)
        wrapper.style.opacity = '1'

        const slidesCount = slider.slides.length
        const container = wrapper.closest('.vc-section').querySelector('.vc-reviews-slider__title-slider-nav')

        if (slider.isLocked && !!container) {
            container.style.display = 'none'
        }

        const leftBtn = !!container ?
            container.querySelector('.vc-reviews-slider__title-arrow--left') :
            wrapper.querySelector('.vc-reviews-slider__arrow--left')

        const rightBtn = !!container ?
            container.querySelector('.vc-reviews-slider__title-arrow--right') :
            wrapper.querySelector('.vc-reviews-slider__arrow--right')

        if (slidesCount > 1) {
            const pagination = wrapper.querySelector('.vc-reviews-slider__pagination')
            if (pagination) {
                pagination.onanimationend = () => {
                    slider.slideNext()
                }
            }
        }

        ;[leftBtn, rightBtn].forEach(el => hideEl(el))

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

        checkArrows(slider)
    }

    const getOptions = wrapper => {
            return {
                spaceBetween: 12,
                slidesPerView: 'auto',
                on: {
                    init: slider => {
                        onSliderInit({
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
                    // 768: {
                    //     slidesPerView: 2,
                    //     spaceBetween: 24,
                    //     slidesPerGroup: 2,
                    // },
                    1024: {
                        slidesPerView: 2,
                        spaceBetween: 32,
                        slidesPerGroup: 2,
                    },
                },
            }
        }

    const initSliders = () => {
        if (swipers.length > 0) return

        sliders.forEach(c => {
            const sliderElement = c.querySelector('.vc-reviews-slider__container')
            if (!sliderElement) return

            new Swiper(sliderElement, getOptions(c))
        })
    }

    initSliders()
})
