import React from 'react'

const Bottom = ({type, children}) => {
	if (!type) return null

	return (
		<section className="vc-bottom  js-bottom" data-type={type}>
			<div className="vc-bottom__content  vc-bottom__content--active js-bottom-content">
				{children}
			</div>
		</section>
	)
}

export default Bottom
