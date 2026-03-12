import React, { useState, useEffect } from 'react'
import Specs from './Specs'
import Services from './Services'
import ServiceType from './ServiceType'
import Schedule from './Schedule'
import Confirmation from './Confirmation'
import { get } from '../../js/global/helpers'
import Modal from "./Modal";

const DoctorsSite = ({ doctorId }) => {
    const [isMobile, setIsMobile] = useState(window.innerWidth < 768)
    const [confirmation, setConfirmation] = useState(null)
    const [doctor, setDoctor] = useState(null)
    const [specs, setSpecs] = useState(null)
    const [selectedSpec, setSelectedSpec] = useState(null)
    const [services, setServices] = useState(null)
    const [selectedServ, setSelectedServ] = useState(null)
    const [depList, setDepList] = useState(null)
    const [ticketId, setTicketId] = useState(null)
    const [isSuccess, setIsSuccess] = useState(false)
    const [activeModal, setActiveModal] = useState(false)
    const [serviceType, setServiceType] = useState('offline') // offline, online, home

    // offline service
    const onOfflineClick = () => {
        setServiceType('offline')
    }

    // online service
    const onOnlineClick = () => {
        setServiceType('online')
    }

    // home service
    const onHomeClick = () => {
        setServiceType('home')
    }

    const onSelectServ = service => {
        setSelectedServ(service)
    }

    const onSelectSpec = spec => {
        setSelectedSpec(spec)
    }

    const getSchedule = async () => {
        try {
            const action = 'vit:doctor.record.getSchedule'
            const params = {action}
            if (!!doctorId) {
                params.docId = doctorId
            }
            const response = await get(params)
            return response
        } catch (e) {
            console.log(e)
            return null
        }
    }

    const block = async ({period, branch}) => {
        const patId = BX.message('USER_ID')
        const docId = doctor.ID
        const depId = branch.ID
        const servId = selectedServ.ID
        const dateStart = period.start.toLocaleString('ru-RU').replace(/,/, '')
        const dateEnd = period.end.toLocaleString('ru-RU').replace(/,/, '')
        try {
            window.dispatchEvent(new Event('show-preloader'))
            const action = 'vit:doctor.record.block'
            const params = {action}
            if (!!patId) {
                params.patId = patId
            }
            if (!!docId) {
                params.docId = docId
            }
            if (!!depId) {
                params.depId = depId
            }
            if (!!servId) {
                params.servId = servId
            }
            if (!!dateStart) {
                params.dateStart = dateStart
            }
            if (!!dateEnd) {
                params.dateEnd = dateEnd
            }
            const response = await get(params)
            window.dispatchEvent(new Event('hide-preloader'))
            return response
        } catch (e) {
            console.log(e)
            window.dispatchEvent(new Event('hide-preloader'))
            return null
        }
    }

    const isElementInViewport = (el) => {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    const onTimeClick = async ({period, branch, serviceType}) => {
        if (!period) {
            console.error('no period selected', period)
            return
        }
        if (!branch) {
            const found = Object.values(depList).find(dep => {
                return dep.ID === period.depId
            })
            branch = found
            if (!found) {
                console.error('no branch selected', branch)
                return
            }
        }

        // проверяем что блок с записью находится в области видимости и скроллим если нет
        const record = document.querySelector('#record')
        if (!!record && !isElementInViewport(record)) {
            record.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
                inline: 'nearest'
            });
        }

        const response = await block({period, branch})
        if (!!response) {
            setTicketId(response)
            setConfirmation(true)
            // response - это tickedId
            // const start = period.start.getTime()
            // const end = period.end.getTime()
            // const url = `/record/confirmation/?docId=${doctorId}&servId=${selectedServ.ID}&depId=${branch.ID}&ticketId=${response}&start=${start}&end=${end}&serviceType=${serviceType}`
            // window.location.assign(url)
        }
    }

    const handleModalClose = () => {
        setActiveModal(false)
        setConfirmation(false)
    }

    const handleModalOpen = (status) => {
        if (status === 'error') {
            setIsSuccess(false)
        }
        if (status === 'success') {
            setIsSuccess(true)
        }
        setActiveModal(true)
        const updateData = async () => {
            try {
                window.dispatchEvent(new Event('show-preloader'))
                const promises = await Promise.all([
                    getSchedule(),
                ])
                const [_schedule] = promises
                setDoctor(Object.values(_schedule.DOCTORS)[0])
                window.dispatchEvent(new Event('hide-preloader'))
            } catch (e) {
                console.log(e)
                window.dispatchEvent(new Event('hide-preloader'))
            }
        }
        updateData()
    }

    useEffect(() => {
        const getData = async () => {
            try {
                window.dispatchEvent(new Event('show-preloader'))
                const promises = await Promise.all([
                    getSchedule(),
                ])
                const [_schedule] = promises
                setDoctor(Object.values(_schedule.DOCTORS)[0])
                window.dispatchEvent(new Event('hide-preloader'))
            } catch (e) {
                console.log(e)
                window.dispatchEvent(new Event('hide-preloader'))
            }
        }
        getData()
    }, [])

    useEffect(() => {
        if (!doctor) return
        if (!!doctor.BRANCHES) {
            setDepList(Object.values(doctor.BRANCHES))
        }
        if (!doctor.SERVICES) {
            setSpecs(null)
            setSelectedSpec(null)
            setServices(null)
            setSelectedServ(null)
            return
        }
        const _specs = Object.values(doctor.SERVICES)
        setSpecs(_specs)
        setSelectedSpec(_specs[0])
    }, [doctor])

    useEffect(() => {
        const onResize = () => {
            if (isMobile === window.innerWidth < 768) return
            setIsMobile(window.innerWidth < 768)
        }
        window.addEventListener('resize', onResize)
        return () => {
            window.removeEventListener('resize', onResize)
        }
    }, [isMobile])

    useEffect(() => {
        // init modal open
        if (serviceType !== 'home') return
        setTimeout(() => {
            window.dispatchEvent(new Event('ajax-loaded'))
        }, 0)
    }, [serviceType])

    useEffect(() => {
        if (!selectedSpec) return
        if (!selectedSpec.ITEMS) {
            setServices(null)
            setSelectedServ(null)
            return
        }
        const _services = selectedSpec.ITEMS
        setServices(_services)
        setSelectedServ(_services[0])
    }, [selectedSpec])

    if (!doctorId || !doctor) return null

    return (
        <>
            <Modal active={activeModal} success={isSuccess} onClose={handleModalClose} />
            {!confirmation && (
                <div className="vc-record">
                    <div className="vc-record__container">
                        <div className="vc-record__filters">
                            <Specs
                                isMobile={isMobile}
                                specs={specs}
                                selectedSpec={selectedSpec}
                                onSelectSpec={onSelectSpec}
                            />
                            {(!!doctor?.ONLINE_SERVICE?.PRICE || !!doctor?.HOME_SERVICE?.PRICE) && (
                                <ServiceType
                                    isMobile={isMobile}
                                    doctor={doctor}
                                    serviceType={serviceType}
                                    onOfflineClick={onOfflineClick}
                                    onOnlineClick={onOnlineClick}
                                    onHomeClick={onHomeClick}
                                />
                            )}
                            {serviceType === 'offline' && (
                                <Services
                                    isMobile={isMobile}
                                    servList={specs}
                                    services={services}
                                    selectedServ={selectedServ}
                                    onSelectServ={onSelectServ}
                                    selectedDoctor={doctor}
                                />
                            )}
                        </div>
                        {serviceType !== 'home' && (
                            <Schedule
                                depList={depList}
                                selectedServ={selectedServ}
                                onTimeClick={onTimeClick}
                                serviceType={serviceType}
                            />
                        )}
                        {serviceType === 'home' && (
                            <div className="vc-record__home-call">
                                <div className="vc-record__home-call-text">
                                    Заполните форму, опишите симптомы. Точную стоимость и время визита врача сообщим
                                    после указания адреса
                                </div>
                                <div className="vc-record__home-call-btn">
                                    <div
                                        className="vc-btn js-open-modal js-set-select"
                                        data-select-name="doctor-select"
                                        data-select-value-id={doctor.ID}
                                        data-name="houseCallModal"
                                    >Вызвать врача на дом
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            )}
            {!!confirmation && <Confirmation ticketId={ticketId} onModalOpen={handleModalOpen}/>}
        </>
    )
}

export default DoctorsSite
