import IMask from 'imask'
import flatpickr from 'flatpickr'
import { Russian } from "flatpickr/dist/l10n/ru.js"

window.addEventListener('DOMContentLoaded', () => {
	const init = () => {
		document.querySelectorAll('.js-date-input-mask').forEach(m => {
			if (!m.dataset.init) {
				IMask(m, {mask: Date})
				m.dataset.init = 'true'
			}
		})

		document.querySelectorAll('.js-phone-mask').forEach(m => {
			if (!m.dataset.init) {
				IMask(m, {mask: '+7 (000) 000-00-00'})
				m.dataset.init = 'true'
			}
		})

		document.querySelectorAll('.js-date-mask').forEach(m => {
			if (!m.dataset.init) {
				flatpickr(m, {
					locale: Russian,
					dateFormat: "d.m.Y",
					disableMobile: true,
				})
				m.dataset.init = 'true'
			}
		})

		document.querySelectorAll('.js-datetime-mask').forEach(m => {
			if (!m.dataset.init) {
				flatpickr(m, {
					locale: Russian,
					enableTime: true,
					dateFormat: "d.m.Y H:i",
					time_24hr: true,
					disableMobile: true,
				})
				m.dataset.init = 'true'
			}
		})
	}

	init()

	window.addEventListener('ajax-loaded', init)
})
