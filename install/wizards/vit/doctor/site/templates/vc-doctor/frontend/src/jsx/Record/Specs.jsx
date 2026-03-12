import React, { useState, useEffect } from 'react'
// import Svg from '../Svg'
import Bottom from '../Bottom'
import SimpleBar from 'simplebar-react'
// import specArrowIcon from '../../img/record/spec-arrow.svg'
// import arrowIcon from '../../img/record/arrow-right.svg'

const Specs = ({ isMobile, specs, selectedSpec, onSelectSpec }) => {
    const [isOpen, setIsOpen] = useState(false)

    const _onSelectSpec = spec => {
        onSelectSpec(spec)
        // hide the bottom
        document.body.click()
    }

    const onSpecOpen = () => {
        setIsOpen(true)
    }

   useEffect(() => {
        if (isMobile && isOpen) {
            document.body.style.overflow = 'hidden'
            window.activateBottom(`vc-bottom-specs`)
            return
        }
        document.body.style.overflow = ''
    }, [isMobile, isOpen])

    useEffect(() => {
        // to trigger bottom activation
        window.dispatchEvent(new Event('ajax-loaded'))

        // closing Bottom components
        const onBodyClick = (e) => {
            if (e.target.closest('.vc-record__filter-spec')) return
            setIsOpen(false)
        }

        document.body.addEventListener('click', onBodyClick)

        return () => {
            document.body.removeEventListener('click', onBodyClick)
        }
    }, [])

    if (!specs) return null

    if (!isMobile) return (
        <>
            <div className="vc-record__filters-section">
                <div className="vc-record__filters-section-title">Специализация</div>
                <div className={`vc-record__filter-specs${isOpen ? ' vc-record__filter-specs--open' : ''}`}>
                    {!!specs.length && specs.map((spec, index) => (
                        <div
                            className={`vc-record__filter-spec${spec.ID === selectedSpec.ID ? ' vc-record__filter-spec--active' : ''}`}
                            key={spec.ID}
                            {...(index > 2 ? { 'data-hide': true } : {})}
                            onClick={() => onSelectSpec(spec)}
                        >
                            {spec.NAME}
                        </div>
                    ))}
                    {!isOpen && specs.length > 3 && (
                        <div className="vc-record__filter-spec" onClick={onSpecOpen}>
                            +{specs.length - 3}
                            <div className="vc-record__filter-spec-arrow">
                                {/*<Svg src={specArrowIcon} />*/}
                                <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1.5L6 6.5L11 1.5" stroke="#9AA2B3" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                                </svg>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </>
    )

    if (!!isMobile) return (
        <>
            {!!selectedSpec && (
                <div className="vc-record__filters-section">
                    <div className="vc-record__filter-specs">
                        <div
                            className="vc-record__filter-spec vc-record__filter-spec--active"
                            onClick={onSpecOpen}
                        >
                            {selectedSpec.NAME}
                            <div className="vc-record__filter-spec-arrow">
                                {/*<Svg src={arrowIcon} />*/}
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 3L11 8L6 13" stroke="#41404D" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            )}
            {!!specs.length && (
                <Bottom type={`vc-bottom-specs`}>
                    <SimpleBar autoHide={true}>
                        {specs.map(spec => (
                            <div
                                className="vc-record__bottom-spec"
                                key={spec.ID}
                                onClick={() => _onSelectSpec(spec)}
                            >
                                {spec.NAME}
                            </div>
                        ))}
                    </SimpleBar>
                </Bottom>
            )}
        </>
    )
}

export default Specs
