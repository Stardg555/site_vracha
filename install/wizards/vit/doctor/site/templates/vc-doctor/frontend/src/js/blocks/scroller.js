class Scroller {
	constructor(el) {
		if (!el) return
		this.el = el
		this.isScrolling = false
		this.touchX = 0
		this.init()
	}
	scrollRight(px) {
		const start = this.el.scrollLeft
		const end = start + px
		let distance
		let x = 0

		const easing = (x) => {
			// return x === 1 ? 1 : 1 - Math.pow(2, -10 * x)
			return 1 - Math.pow(1 - x, 4)
		}

		const scrollFraction = () => {
			x = x < 1?
				x + 1/60 :
				1
			this.el.scrollLeft = start + distance * easing(x)
			if (x === 1) return
			window.requestAnimationFrame(scrollFraction)
		}

		distance = end - start
		distance = Math.abs(distance)

		if (distance > 1) {
			window.requestAnimationFrame(scrollFraction)
		}
	}

	scrollLeft(px) {
		const start = this.el.scrollLeft
		const end = start - px
		let distance
		let x = 0

		const easing = (x) => {
			// return x === 1 ? 1 : 1 - Math.pow(2, -10 * x)
			return 1 - Math.pow(1 - x, 4)
		}

		const scrollFraction = () => {
			x = x < 1?
				x + 1/60 :
				1
			this.el.scrollLeft = start - distance * easing(x)
			if (x === 1) return
			window.requestAnimationFrame(scrollFraction)
		}

		distance = end - start
		distance = Math.abs(distance)

		if (distance > 1) {
			window.requestAnimationFrame(scrollFraction)
		}
	}

	scrollX(px) {
		this.el.scrollLeft -= `${px}`
	}
	onTouchStart = e => {
		e.stopPropagation()
		this.isScrolling = true
	}
	onMouseDown = e => {
		e.preventDefault()
		e.stopPropagation()
	}
	onTouchMove = e => {
		e.preventDefault()
		e.stopPropagation()
		if (!this.isScrolling) return
		this.touchX = !this.touchX ? e.touches[0].clientX : this.touchX
		this.scrollX(e.touches[0].clientX - this.touchX)
		this.touchX = e.touches[0].clientX
	}
	onMouseMove = e => {
		e.preventDefault()
		e.stopPropagation()
		if (!e.buttons) return
		this.isScrolling = true
		this.scrollX(e.movementX)
	}
	onMouseOut = () => {
		this.isScrolling = false
	}
	onTouchEnd = e => {
		e.stopPropagation()
		this.isScrolling = false
		this.touchX = 0
	}
	onMouseUp = e => {
		e.preventDefault()
		e.stopPropagation()
		this.touchX = 0
	}
	onClick = e => {
		this.isScrolling && e.preventDefault()
		this.isScrolling && e.stopPropagation()
		this.isScrolling = false
	}
	init() {
		this.el.addEventListener('touchstart', this.onTouchStart)
		this.el.addEventListener('mousedown', this.onMouseDown)
		this.el.addEventListener('touchend', this.onTouchEnd)
		this.el.addEventListener('mouseup', this.onMouseUp)
		this.el.addEventListener('touchmove', this.onTouchMove)
		this.el.addEventListener('mousemove', this.onMouseMove)
		this.el.addEventListener('mouseout', this.onMouseOut)
		this.el.addEventListener('click', this.onClick)
	}
}

export default Scroller
