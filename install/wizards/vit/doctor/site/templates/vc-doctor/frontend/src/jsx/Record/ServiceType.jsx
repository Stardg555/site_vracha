import React, { useState, useEffect } from 'react'
// import Svg from '../Svg'
import Bottom from '../Bottom'
import SimpleBar from 'simplebar-react'
// import arrowIcon from '../../img/record/arrow-right.svg'

const ServiceType = ({ isMobile, doctor, serviceType, onOnlineClick, onOfflineClick, onHomeClick }) => {
    const [isOpen, setIsOpen] = useState(false)

    const _onOnlineClick = () => {
        document.body.click()
        onOnlineClick()
    }
    const _onOfflineClick = () => {
        document.body.click()
        onOfflineClick()
    }
    const _onHomeClick = () => {
        document.body.click()
        onHomeClick()
    }

   useEffect(() => {
        if (isMobile && isOpen) {
            document.body.style.overflow = 'hidden'
            window.activateBottom(`vc-bottom-service-type`)
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

    if (!isMobile) return (
        <div className="vc-record__filters-section">
            <div className="vc-record__filters-section-title">Тип приёма</div>
            <div className="vc-record__filter-specs vc-record__filter-specs--open">
                <div
                    className={`vc-record__filter-spec${serviceType === 'offline' ? ' vc-record__filter-spec--active' : ''}`}
                    onClick={onOfflineClick}
                >
                    Прием в клинике
                </div>
                {!!doctor.ONLINE_SERVICE && !!doctor.ONLINE_SERVICE.PRICE && (
                    <div
                        className={`vc-record__filter-spec${serviceType === 'online' ? ' vc-record__filter-spec--active' : ''}`}
                        onClick={onOnlineClick}
                    >
                        Онлайн-консультация
                    </div>
                )}
                {!!doctor.HOME_SERVICE && !!doctor.HOME_SERVICE.PRICE && (
                    <div
                        className={`vc-record__filter-spec${serviceType === 'home' ? ' vc-record__filter-spec--active' : ''}`}
                        onClick={onHomeClick}
                    >
                        Прием на дому
                    </div>
                )}
            </div>
        </div>
    )

    if (!!isMobile) return (
        <div className="vc-record__filters-section">
            <div
                className="vc-record__filter-specs"
                onClick={() => setIsOpen(true)}
            >
                <div className="vc-record__filter-spec vc-record__filter-spec--active">
                    <>
                        {serviceType === 'offline'
                            ? 'Прием в клинике'
                            : serviceType === 'online'
                            ? 'Онлайн-консультация'
                            : serviceType === 'home'
                            ? 'Прием на дому' : ''}
                    </>
                    <div className="vc-record__filter-spec-arrow">
                        {/*<Svg src={arrowIcon} />*/}
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 3L11 8L6 13" stroke="#41404D" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
            <Bottom type={`vc-bottom-service-type`}>
                <SimpleBar autoHide={true}>
                    <div
                        className="vc-record__bottom-service"
                        onClick={_onOfflineClick}
                    >
                        <div className="vc-record__bottom-service-title">Прием в клинике</div>
                    </div>
                    {!!doctor.ONLINE_SERVICE && !!doctor.ONLINE_SERVICE.PRICE && (
                        <div
                            className="vc-record__bottom-service"
                            onClick={_onOnlineClick}
                        >
                            <div className="vc-record__bottom-service-title">Онлайн-консультация</div>
                        </div>
                    )}
                    {!!doctor.HOME_SERVICE && !!doctor.HOME_SERVICE.PRICE && (
                        <div
                            className="vc-record__bottom-service"
                            onClick={_onHomeClick}
                        >
                            <div className="vc-record__bottom-service-title">Прием на дому</div>
                        </div>
                    )}
                </SimpleBar>
            </Bottom>
        </div>
    )
}

export default ServiceType
