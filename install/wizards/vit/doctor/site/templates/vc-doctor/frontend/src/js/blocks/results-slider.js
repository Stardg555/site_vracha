import Swiper from "swiper";

window.addEventListener('DOMContentLoaded', () => {
    const results = document.querySelectorAll('.vc-results')
    if (results.length === 0) return

    const activeClass = 'vc-results__title-arrow--active'

    const hideEl = el => {
        if (!el) return
        el.classList.remove(activeClass)
    }

    const showEl = el => {
        if (!el) return
        el.classList.add(activeClass)
    }

    const checkArrows = (wrapper, slider) => {
        const { el, isBeginning, isEnd } = slider

        const leftBtn = wrapper.querySelector('.vc-results__title-arrow--left')

        const rightBtn = wrapper.querySelector('.vc-results__title-arrow--right')

        isEnd && hideEl(rightBtn)
        !isEnd && showEl(rightBtn)

        isBeginning && hideEl(leftBtn)
        !isBeginning && showEl(leftBtn)
    }

    const onSliderInit = ({wrapper, slider}) => {
        // const slidesCount = slider.slides.length
        wrapper.style.opacity = '1'
        const leftBtn = wrapper.querySelector('.vc-results__title-arrow--left')

        const rightBtn = wrapper.querySelector('.vc-results__title-arrow--right')
        // if (
        //     (window.innerWidth > 1023 && slidesCount < 5) ||
        //     (window.innerWidth > 767 && slidesCount < 4) ||
        //     (window.innerWidth > 499 && slidesCount < 3) ||
        //     (window.innerWidth < 500 && slidesCount < 2)
        // ) {
        //     ;[leftBtn, rightBtn].forEach(el => hideEl(el))
        //     return
        // }
        !!leftBtn &&
        leftBtn.addEventListener('click', () => {
            slider.slidePrev()
        })

        !!rightBtn &&
        rightBtn.addEventListener('click', () => {
            slider.slideNext()
        })

        checkArrows(wrapper, slider)
    }

    const init = (slider, wrapper) => {
        if (slider.dataset.init === 'true') {
            return
        }

        new Swiper(slider, {
            slidesPerView: 'auto',
            // spaceBetween: 24,
            pagination: {
                el: '.vc-results__pagination',
                type: 'bullets',
                clickable: true,
                bulletClass:'swiper-pagination-bullet'
            },
            on: {
                init: slider => {
                    onSliderInit({
                        wrapper,
                        slider,
                    })
                },
                slideNextTransitionEnd: (slider) => {
                    checkArrows(wrapper, slider)
                },
                slidePrevTransitionEnd: (slider) => {
                    checkArrows(wrapper, slider)
                },
            },
            breakpoints: {
                768: {
                    // slidesPerView: 'auto',
                    slidesPerView: 2,
                    spaceBetween: 32,
                }
            }
        })

        slider.dataset.init = 'true'
    }

    // const sliderElements = document.querySelectorAll('.vc-results__content')

    results.forEach(wrapper => {
        const sliderElement = wrapper.querySelector('.vc-results__main')
        init(sliderElement, wrapper)
    })
})
