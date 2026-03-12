import React, { useState, useEffect } from 'react'

const Svg = ({ src, onClick }) => {
	const [icon, setIcon] = useState(null)

	useEffect(() => {
		const controller = new AbortController()
		const signal = controller.signal

		;(async () => {
			try {
				const response = await fetch(src, { signal })
				const svg = await response.text()
                if (!svg || svg.match(/<!DOCTYPE html>/)) {
                    setIcon(null)
                    return
                }
				!!svg && setIcon(svg)
			} catch(e) {}
		})()

		return () => controller.abort()
	}, [])

	if (!icon) return null

	return <div dangerouslySetInnerHTML={{ __html: icon }} onClick={onClick}></div>
}

export default Svg
