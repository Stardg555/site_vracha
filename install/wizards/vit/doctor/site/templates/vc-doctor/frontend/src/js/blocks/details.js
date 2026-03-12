// import { FTScroller } from "ftscroller";
import Swiper from 'swiper'


const init = () => {
    const details = document.querySelector('.vc-details')
    if (!details) return
    if (details.dataset.init === 'true') return

    const sliders = document.querySelectorAll('.vc-details')
    if (sliders.length === 0) return

    const initSlider = () => {
        const sliderElement = details.querySelector('.vc-details__header')
        if (!sliderElement) return

        new Swiper(sliderElement, {
            spaceBetween: 0,
            slidesPerView: 'auto',

        })
    }
    initSlider()

	// const isAndroid = document.documentElement.classList.contains('android')

    // const header = details.querySelector('.vc-details__header')
    // const scroller = new FTScroller(header, {
    //     scrollbars: false,
    //     scrollingY: false,
    //     bouncing: false,
    //     flinging: isAndroid? false : true,
    // })
    //
    // setTimeout(() => {
    //     scroller.updateDimensions()
    // }, 300)

    const tabs = details.querySelectorAll('.vc-details__tab')
    const contents = details.querySelectorAll('.vc-details__content')

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const name = tab.dataset.name

            tabs.forEach(t => {
                if (t === tab) {
                    t.classList.add('vc-details__tab--active')
                    return
                }
                t.classList.remove('vc-details__tab--active')
            })

            contents.forEach(content => {
                if (content.dataset.name === name) {
                    content.classList.add('vc-details__content--active')
                    return
                }
                content.classList.remove('vc-details__content--active')
            })
        })
    })

    details.setAttribute('data-init', 'true')

    // scroller.updateDimensions()
}

;['DOMContentLoaded', 'ajax-loaded'].forEach(event => {
    window.addEventListener(event, init)
})
