// import {getGETParams} from '../global/helpers'
import ymaps from 'ymaps'

window.addEventListener('DOMContentLoaded', async () => {
	const ymapsContainer = document.querySelector('.js-ym-container')
	if (!ymapsContainer) return

	// const branch = `branch-${getGETParams().branch}`
	let baloonIcon = ymapsContainer.dataset.baloon
	let baloonOpaqueIcon = ymapsContainer.dataset.baloonopaque
	ymapsContainer.style.opacity = '0'
	let ym
	const ymEl = ymapsContainer.querySelector('.js-ym')
	let globalCenter = ymEl.dataset.center.replace(/\s/g, '').split(',')
	if (window.innerWidth < 768) {
		globalCenter = ymEl.dataset.mobileCenter.replace(/\s/g, '').split(',')
	}
	let zoom = ymEl.dataset.zoom
	let mobileZoom = ymEl.dataset.mobileZoom
	let activeZoom = ymEl.dataset.activeZoom
	const items = [...ymapsContainer.querySelectorAll('.js-ym-addr')].map(i => {
		return {
			coordinates: i.dataset.loc.replace(/\s/g, '').split(','),
			el: i,
			branch: i.dataset.branch,
		}
	})

	const hintActiveClass = 'vc-branches-map__card--active'
	const hints = ymapsContainer.querySelectorAll('.vc-branches-map__card')

	hints.forEach(h => {
		h.addEventListener('click', ({target}) => {
			if (target.closest('.vc-branches-map__card-close')) {
				h.classList.remove(hintActiveClass)
				window.dispatchEvent(new Event('ymapsHintClose'))
			}
		})
	})

	// // isDragable map
	// const container = document.querySelector('.vc-main-branches')
	// let dragable = 'drag'
	// if (container) {
	// 	dragable = container.classList.contains('vc-main-branches--second-variant') ?
	// 		'nodrag' : 'drag'
	// }

	const init = maps => {
		// setup map
		// let dragable = 'drag'
		// if (window.innerWidth < 768) {
		// 	zoom = mobileZoom
		// 	dragable = null
		// }
		ym = new maps.Map(ymEl, {
			center: globalCenter,
			zoom: zoom,
			controls: ['zoomControl', 'routeButtonControl'],
			behaviors: ['drag', 'multiTouch'],
		})

		// отключение скролла карты
		// ym.behaviors.get('drag').disable()

		// route setup
		const control = ym.controls.get('routeButtonControl')
		control.routePanel.state.set({
			type: 'auto',
			toEnabled: true,
		})
		control.routePanel.options.set({
			reverseGeocoding: true,
		})

		let currentPosition
		maps.geolocation
			.get({
				// Зададим способ определения геолокации
				// на основе ip пользователя.
				provider: 'yandex',
				// Включим автоматическое геокодирование результата.
				autoReverseGeocode: true,
			})
			.then(function (result) {
				currentPosition = result.geoObjects.position
				control.routePanel.state.set({
					from: currentPosition,
				})
			})

		// setup placemarks
		items.forEach(i => {
			i.placemark = new maps.Placemark(
				i.coordinates,
				{},
				{
					iconLayout: 'default#image',
					iconImageHref: baloonOpaqueIcon,
					iconImageSize: [47, 45],
					iconImageOffset: [-23, -45],
				},
			)

			i.placemark.data = {
				el: i.el,
				branch: i.branch,
			}

			const mainBranchesContainer = document.querySelector('.vc-main-branches')
			let isSinglePlacemark = false
			if (!!mainBranchesContainer) {
				isSinglePlacemark = mainBranchesContainer.classList.contains('vc-main-branches--second-variant')
			}

			// hover event on the placemark
			i.placemark.events.add('mouseenter', function () {
				if (!!isSinglePlacemark) return
				const thisPlacemark = i.placemark

				items.forEach(item => {
					const placemark = item.placemark
					if (placemark === thisPlacemark) {
						placemark.options.set('iconImageHref', baloonIcon)
						return
					}
				})
			})

			// hover event on the placemark
			i.placemark.events.add('mouseleave', function () {
				if (!!isSinglePlacemark) return
				const thisPlacemark = i.placemark

				items.forEach(item => {
					const placemark = item.placemark
					// we don't want to touch the active placemark
					if (item.el.classList.contains(hintActiveClass)) return

					if (placemark === thisPlacemark) {
						placemark.options.set('iconImageHref', baloonOpaqueIcon)
						return
					}
				})
			})

			// click event on the placemark
			i.placemark.events.add('click', function () {
				if (!!isSinglePlacemark) return
				const thisPlacemark = i.placemark
				const data = thisPlacemark.data

				const hint = data.el

				hints.forEach(h => {
					h.classList.remove(hintActiveClass)
				})
				// Отображение информации о филиале на карте
				// hint.classList.add(hintActiveClass)
				items.forEach(item => {
					const placemark = item.placemark
					if (placemark === thisPlacemark) {
						placemark.options.set('iconImageHref', baloonIcon)
						placemark.options.set('iconImageSize', [66, 62])
						placemark.options.set('iconImageOffset', [-33, -62])
						ym.setCenter(placemark.geometry._coordinates, activeZoom, null)
						return
					}
					placemark.options.set('iconImageHref', baloonOpaqueIcon)
					placemark.options.set('iconImageSize', [47, 45])
					placemark.options.set('iconImageOffset', [-23, -45])
				})
			})
			// attach placemark to the map
			ym.geoObjects.add(i.placemark)

			// show active placemark if there is one
			// const defaultActiveBranch = items.find(i => {
			// 	const {placemark} = i
			// 	return placemark?.data.branch === branch
			// })

			// setTimeout(() => {
			// 	!!defaultActiveBranch
			// 		? defaultActiveBranch.placemark.events.types.click[0]()
			// 		: items[0].placemark.events.types.click[0]()
			// }, 0)
		})

		window.addEventListener('ymapsHintClose', () => {
			if (window.innerWidth < 768) {
				zoom = mobileZoom
			}

			ym.setCenter(globalCenter, zoom, null)
			items.forEach(item => {
				item.placemark.options.set('iconImageHref', baloonOpaqueIcon)
				item.placemark.options.set('iconImageSize', [47, 45])
				item.placemark.options.set('iconImageOffset', [-23, -45])
			})
		})
	}

	ymaps
		.load(
			'https://api-maps.yandex.ru/2.1/?apikey=198c7397-842f-4a45-901b-2886e7ac63ba&lang=ru_RU',
		)
		.then(maps => {
			init(maps)
			ymapsContainer.style.opacity = '1'
		})
		.catch(e => {
			console.log(e)
		})

	const initFilters = async () => {
		const lists = document.querySelectorAll('.vc-contacts__main')
		if (lists.length === 0) return

		// search filters
		const initSearchFilters = () => {
			lists.forEach(list => {
				const filters = {}

				// const citySelect = list.querySelector(
				// 	'.vc-search__select-input[name=city]',
				// )
				// const districtSelect = list.querySelector(
				// 	'.vc-search__select-input[name=district]',
				// )

				const branchSelect = list.querySelector('.vc-search__input[name=branch]')
				const cards = list.querySelectorAll('.vc-branches__item')

				const updateSlides = ({ select }) => {
					console.log('update slides')
					filters[select.name] = select.value

					// console.log(items)
					cards.forEach(item => {
						let showSlide = true
						const branchName = item.dataset.title.toLowerCase()
						Object.keys(filters).forEach(key => {
							if (
								!!filters[key] &&
								item.dataset[key] !== filters[key] &&
								!branchName.includes(select.value.toLowerCase())
							) {
								showSlide = false
								return
							}
						})
						if (!showSlide) {
							item.style.display = 'none'
							return
						}
						item.style.display = ''
						globalCenter = item.dataset.loc.replace(/\s/g, '').split(',')
					})
					// console.log(globalCenter)
					window.dispatchEvent(new Event('ymapsHintClose'))
					// console.log(item.dataset.loc)
				}

				const updateDistrictSelect = () => {
					const selectItems = districtSelect
						.closest('.vc-search__select')
						.querySelectorAll('.vc-search__select-item')
					selectItems.forEach(selectItem => {
						let hideSelectItem = true
						if (
							filters.city === '' ||
							selectItem.dataset.city === '' ||
							selectItem.dataset.city === filters.city
						) {
							hideSelectItem = false
						}
						if (hideSelectItem) {
							selectItem.style.display = 'none'
							return
						}
						selectItem.style.display = ''
					})
				}

				// const updateCitySelect = () => {
				// 	const selectItems = citySelect
				// 		.closest('.vc-search__select')
				// 		.querySelectorAll('.vc-search__select-item')
				// 	const districtItems = districtSelect
				// 		.closest('.vc-search__select')
				// 		.querySelectorAll('.vc-search__select-item')
				// 	const selectedDistrictCity = [...districtItems].find(
				// 		districtItem => districtItem.dataset.id === filters.district,
				// 	).dataset.city
				// 	selectItems.forEach(selectItem => {
				// 		let hideSelectItem = true
				// 		if (
				// 			selectedDistrictCity === '' ||
				// 			selectItem.dataset.id === '' ||
				// 			selectItem.dataset.id === selectedDistrictCity
				// 		) {
				// 			hideSelectItem = false
				// 		}
				// 		if (hideSelectItem) {
				// 			selectItem.style.display = 'none'
				// 			return
				// 		}
				// 		selectItem.style.display = ''
				// 	})
				// }

				// citySelect.addEventListener('change', () => {
				// 	updateSlides({ select: citySelect })
				// 	updateDistrictSelect()
				// })
				// districtSelect.addEventListener('change', () => {
				// 	updateSlides({ select: districtSelect })
				// 	updateCitySelect()
				// })
				// branchSelect.addEventListener('input', () => {
				// 	updateSlides({ select: branchSelect })
				// })
			})
		}

		initSearchFilters()
	}
	initFilters()
})
