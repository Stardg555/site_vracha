window.addEventListener('DOMContentLoaded', () => {

    const spoilers = document.querySelectorAll('.vc-spoilers')
    if (spoilers.length === 0) return

    const initSpoiler = (spoiler) => {
        const openCls = 'vc-spoilers__item--open'

        const open = (item) => {
            const content = item.querySelector('.vc-spoilers__item-content')
            content.style.height = `${content.scrollHeight}px`
            item.classList.add(openCls)
            content.ontransitionend = () => {
                content.style.height = 'auto'
                content.ontransitionend = null
            }
        }

        const close = (item) => {
            const content = item.querySelector('.vc-spoilers__item-content')
            content.style.height = content.getBoundingClientRect().height + 'px'
            setTimeout(() => {
                content.style.height = '0px'
                item.classList.remove(openCls)
            }, 0)
        }

        const toggle = (item) => {
            const isOpen = item.classList.contains(openCls)
            if (!isOpen) {
                open(item)
                return
            }
            close(item)
        }

        spoiler.addEventListener('click', (e) => {
            if (!e.target.closest('a')) toggle(spoiler)
        })
    }

    const init = (spoilers) => {

        if (spoilers.dataset.init === 'true') return

        const items = spoilers.querySelectorAll('.vc-spoilers__item')

        items.forEach(i => initSpoiler(i))

        spoilers.dataset.init = 'true'
    }

    spoilers.forEach(s => init(s))
})