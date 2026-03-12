window.addEventListener('DOMContentLoaded', async () => {
	const preloader = document.querySelector('.vc-preloader')
	if (!preloader) return

	const activeCls = 'vc-preloader--active'

	const show = () => {
		preloader.classList.add(activeCls)
	}
	window.addEventListener('show-preloader', show)

	const hide = () => {
		preloader.classList.remove(activeCls)
	}
	window.addEventListener('hide-preloader', hide)
})
