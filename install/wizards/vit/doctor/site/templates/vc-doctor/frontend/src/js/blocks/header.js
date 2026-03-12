const initHeader = () => {
	const header = document.querySelector('.vc-header')
	if (!header || header.dataset.init === 'true') return

    // header scroll action
    const scrollCls = 'vc-header--scroll'
    const initHeaderScroll = () => {
        const onScroll = () => {
            if (window.scrollY > 10) {
                header.classList.add(scrollCls)
                return
            }
            header.classList.remove(scrollCls)
        }
        window.addEventListener('scroll', onScroll)
        onScroll()
    }
    initHeaderScroll()

    // mobile menu
    const burger = header.querySelector('.vc-header__burger')
    const menuOpenCls = 'vc-header--menu-open'
    const initBurger = () => {
        const open = () => {
            header.classList.add(menuOpenCls)
        }
        const close = () => {
            header.classList.remove(menuOpenCls)
        }
        const toggle = () => {
            const isOpen = header.classList.contains(menuOpenCls)
            if (!isOpen) {
                open()
                return
            }
            close()
        }
        const onClick = () => {
            toggle()
        }
        burger.addEventListener('click', onClick)

        const mobileLinks = header.querySelectorAll('.vc-menu__item-title')
        mobileLinks.forEach(link => {
            link.addEventListener('click', close)
        })
    }
    !!burger && initBurger()

	header.setAttribute('data-init', 'true')
}

;['DOMContentLoaded', 'ajax-loaded'].forEach(event => window.addEventListener(event, initHeader))
