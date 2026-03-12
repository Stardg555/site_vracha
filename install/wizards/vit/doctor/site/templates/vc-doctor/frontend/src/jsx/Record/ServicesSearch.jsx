import React, { useState, useEffect } from 'react'
// import Svg from '../Svg'
// import closeIcon from '../../img/record/close.svg'
// import searchIcon from '../../img/record/search.svg'
// import serviceIcon from '../../img/record/service.svg'

const ServicesSearch = ({
    servList,
    onSelectServ,
    active,
    onClose,
    selectedDoctor,
    isDiagnostics,
    selectedServ,
}) => {
    const [search, setSearch] = useState('')
    const [services, setServices] = useState(null)
    const [_selectedServ, _setSelectedServ] = useState(null)

    useEffect(() => {
        if (!selectedDoctor) return
        if (!selectedDoctor.SERVICES) return
        const _services = []
        let _defaultService = null

        Object.values(selectedDoctor.SERVICES).forEach(spec => {
            Object.values(spec.ITEMS).forEach(service => {
                _services.push(service)
                if (!_defaultService) {
                    _defaultService = Object.values(spec.ITEMS).find(
                        service => service.ID === selectedDoctor.MAIN_SERVICE.ID
                    )
                }
            })
        })

        if (!!selectedServ && !!selectedServ.ID) {
            let _foundService = _services.find(serv => serv.ID == selectedServ.ID)
            if (!!_foundService) {
                _setSelectedServ(selectedServ)
                return
            }
        }

        if (!!_defaultService) {
            _setSelectedServ(_defaultService)
        }

    }, [selectedDoctor, selectedServ])

    useEffect(() => {
        const onBodyClick = e => {
            if (e.target.closest('.vc-record__services-all')) return
            if (e.target.closest('.vc-record__services-toggle-all')) return
            if (e.target.closest('.vc-result__select')) return
            if (e.target.closest('.vc-record__filter-service')) return
            onClose()
        }
        document.body.addEventListener('click', onBodyClick)
        return () => {
            document.body.removeEventListener('click', onBodyClick)
        }
    }, [])

    useEffect(() => {
        if (!servList) return
        if (!!selectedDoctor?.SERVICES) {
            setServices(Object.values(selectedDoctor.SERVICES))
            return
        }
        setServices(servList)
    }, [servList, selectedDoctor])

    useEffect(() => {
        if (!isDiagnostics) return
        if (!selectedDoctor) return
        setServices(selectedDoctor.SERVICES)
    }, [isDiagnostics, selectedDoctor])

    useEffect(() => {
        if (!search.trim()) {
            if (!!selectedDoctor && !!selectedDoctor.SERVICES) {
                setServices(Object.values(selectedDoctor.SERVICES))
                return
            }
            setServices(servList)
            return
        }

        let _services = Object.values(servList)
        if (!!selectedDoctor && !!selectedDoctor.SERVICES) {
            _services = Object.values(selectedDoctor.SERVICES)
        }

        let _filteredServices = []
        _services.forEach(category => {
            let _category = {...category}
            if (category.NAME.toLowerCase().includes(search.toLowerCase())) {
                _filteredServices.push(_category)
                return
            }
            let items = []
            Object.values(category.ITEMS).forEach(service => {
                if (service.NAME.toLowerCase().includes(search.toLowerCase())) {
                    items.push(service)
                }
            })
            _category.ITEMS = items
            _filteredServices.push(_category)
        })
        setServices(_filteredServices)
    }, [search])

    return (
        <div
            className={`vc-record__services-all ${active ? 'vc-record__services-all--active' : ''}`}
        >
            <div className="vc-record__services-all-close" onClick={onClose}>
                {/*<Svg src={closeIcon} />*/}
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 4L4 20M20 20L4 4" stroke="#788D98" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                </svg>
            </div>
            <div className="vc-record__services-search-wrapper">
                <div className="vc-record__services-search">
                    <div className="vc-record__services-search-icon">
                        {/*<Svg src={searchIcon} />*/}
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 17C13.866 17 17 13.866 17 10C17 6.13401 13.866 3 10 3C6.13401 3 3 6.13401 3 10C3 13.866 6.13401 17 10 17Z" stroke="#788D98" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                            <path d="M15 15L20 20" stroke="#788D98" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                        </svg>
                    </div>
                    <input
                        type="text"
                        className="vc-record__services-search-input"
                        value={search}
                        placeholder="Найти"
                        onChange={e => setSearch(e.target.value)}
                    />
                </div>
            </div>
            <div className="vc-record__services-wrapper">
                {!!services &&
                    !!services.length &&
                    services.map(category => (
                        <div className="vc-record__services-section" key={category.ID}>
                            <div className="vc-record__services-section-title">
                                {category.NAME}
                            </div>
                            <div className="vc-record__services-section-list">
                                {Object.values(category.ITEMS)?.map(service => (
                                        <div
                                            className={`vc-record__services-section-item${_selectedServ?.ID == service.ID ? ' vc-record__services-section-item--selected' : ''}`}
                                            key={service.ID}
                                            onClick={() => {
                                                onClose()
                                                onSelectServ(service)
                                            }}
                                        >
                                            <div className="vc-record__services-section-item-icon">
                                                {/*<Svg src={serviceIcon} />*/}
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10 2.5H12.5C12.6326 2.5 12.7598 2.55268 12.8536 2.64645C12.9473 2.74021 13 2.86739 13 3V13.5C13 13.6326 12.9473 13.7598 12.8536 13.8536C12.7598 13.9473 12.6326 14 12.5 14H3.5C3.36739 14 3.24021 13.9473 3.14645 13.8536C3.05268 13.7598 3 13.6326 3 13.5V3C3 2.86739 3.05268 2.74021 3.14645 2.64645C3.24021 2.55268 3.36739 2.5 3.5 2.5H6" stroke="#788D98" strokeLinecap="round" strokeLinejoin="round"/>
                                                    <path d="M5.5 4.5V4C5.5 3.33696 5.76339 2.70107 6.23223 2.23223C6.70107 1.76339 7.33696 1.5 8 1.5C8.66304 1.5 9.29893 1.76339 9.76777 2.23223C10.2366 2.70107 10.5 3.33696 10.5 4V4.5H5.5Z" stroke="#788D98" strokeLinecap="round" strokeLinejoin="round"/>
                                                    <path d="M6.5 9.5H9.5" stroke="#788D98" strokeLinecap="round" strokeLinejoin="round"/>
                                                    <path d="M8 8V11" stroke="#788D98" strokeLinecap="round" strokeLinejoin="round"/>
                                                </svg>
                                            </div>
                                            <div className="vc-record__services-section-item-title">
                                                {service.NAME}
                                            </div>
                                            <div className="vc-record__services-section-item-price">
                                                {service.PRICE}
                                            </div>
                                        </div>
                                    ))}
                            </div>
                        </div>
                    ))}
            </div>
        </div>
    )
}

export default ServicesSearch
