window.addEventListener('DOMContentLoaded', async () => {
	const menu = document.querySelector('.vc-menu')
	if (!menu) return

	const HEADER_BREAK_POINT = 1279
	const menuItems = menu.querySelectorAll('.vc-menu__item')
	const menuItemOpenCls = 'vc-menu__item--open'

	if (window.innerWidth > HEADER_BREAK_POINT) {
		return
	}

	// new menu
	const openMenuItem = menuItem => {
		const itemList = menuItem.querySelector('.vc-menu__item-list')
		if (!itemList) return
		// itemList.style.height = `${itemList.scrollHeight}px`
		menuItem.classList.add(menuItemOpenCls)
	}

	const closeMenuItem = menuItem => {
		const itemList = menuItem.querySelector('.vc-menu__item-list')
		if (!itemList) return
		menuItem.classList.remove(menuItemOpenCls)
	}

	const clickHandler = (e, item) => {
		const {target} = e
		if (!target.closest('.vc-menu__link') && !!item.querySelector('.vc-menu__item-list')) {
			e.preventDefault()
		}

		const backArrow = target.closest('.vc-menu__item-arrow-back')
		if (!!backArrow) {
			closeMenuItem(item)
			return
		}
		openMenuItem(item)
	}

	menuItems.forEach(menuItem => {
		menuItem.addEventListener('click', (e) => clickHandler(e, menuItem))
	})

	window.addEventListener('resize', () => {
		menuItems.forEach(item => {
			closeMenuItem(item)
		})
	})
})
