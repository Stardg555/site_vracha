import React, { useState, useEffect } from 'react'
import Svg from '../Svg'
import ServicesSearch from './ServicesSearch'
import Bottom from '../Bottom'
import SimpleBar from 'simplebar-react'
import arrowIcon from '../../img/record/arrow-right.svg'

const Services = ({ isMobile, servList, services, selectedServ, onSelectServ, selectedDoctor }) => {
    const [allServices, setAllServices] = useState(false)
    const [isOpen, setIsOpen] = useState(false)
    const [isOverlay, setIsOverlay] = useState(false)

    const _onSelectServ = service => {
        onSelectServ(service)
        // hide the bottom
        document.body.click()
    }

    useEffect(() => {
        setIsOverlay(allServices)
    }, [allServices])

    useEffect(() => {
        const record = document.querySelector('.vc-record')
        !!record &&
            record.classList.toggle('vc-record--is-overlay', isOverlay)
        document.body.style.overflow = isOverlay ? 'hidden' : ''
    }, [isOverlay])

   useEffect(() => {
        if (isMobile && isOpen) {
            document.body.style.overflow = 'hidden'
            window.activateBottom(`vc-bottom-services`)
            return
        }
        document.body.style.overflow = ''
    }, [isMobile, isOpen])

    useEffect(() => {
        // to trigger bottom activation
        window.dispatchEvent(new Event('ajax-loaded'))

        // closing Bottom components
        const onBodyClick = () => {
            setIsOpen(false)
        }

        document.body.addEventListener('click', onBodyClick)

        return () => {
            document.body.removeEventListener('click', onBodyClick)
        }
    }, [])

    if (!selectedServ) return null

    if (!isMobile) return (
        <div className="vc-record__filters-section">
            <div className="vc-record__filter-service-wrapper">
                <div
                    className="vc-record__filter-service"
                    onClick={() => setAllServices(true)}
                >
                    <div className="vc-record__filter-service-content">
                        <div className="vc-record__filter-service-title">
                            {selectedServ.NAME}
                        </div>
                        <div className="vc-record__filter-service-price">
                            {selectedServ.PRICE.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ')}
                        </div>
                    </div>
                    <div className="vc-record__filter-service-arrow">
                        {/*<Svg src={arrowIcon} />*/}
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 3L11 8L6 13" stroke="#41404D" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
            <ServicesSearch
                servList={servList}
                onSelectServ={onSelectServ}
                active={allServices}
                selectedDoctor={selectedDoctor}
                selectedServ={selectedServ}
                onClose={() => {
                    setAllServices(false)
                }}
            />
        </div>
    )

    if (!!isMobile) return (
        <div className="vc-record__filters-section">
            <div className="vc-record__filter-service-wrapper">
                <div
                    className="vc-record__filter-service"
                    onClick={() => setIsOpen(true)}
                >
                    <div className="vc-record__filter-service-content">
                        <div className="vc-record__filter-service-title">
                            {selectedServ.NAME}
                        </div>
                        <div className="vc-record__filter-service-price">
                            {selectedServ.PRICE.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ')}
                        </div>
                    </div>
                    <div className="vc-record__filter-service-arrow">
                        {/*<Svg src={arrowIcon} />*/}
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 3L11 8L6 13" stroke="#41404D" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
            {!!services && !!services.length && (
                <Bottom type={`vc-bottom-services`}>
                    <SimpleBar autoHide={true}>
                        {services.map(service => (
                            <div
                                className="vc-record__bottom-service"
                                key={service.ID}
                                onClick={() => _onSelectServ(service)}
                            >
                                <div className="vc-record__bottom-service-title">
                                    {service.NAME}
                                </div>
                                <div className="vc-record__bottom-service-price">
                                    {service.PRICE.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ')}
                                </div>
                            </div>
                        ))}
                    </SimpleBar>
                </Bottom>
            )}
        </div>
    )
}

export default Services
