import React, { useState, useEffect, useRef } from 'react'
import { get } from '../../js/global/helpers'
import IMask from 'imask'
// import Svg from "../Svg";
// import checkIcon from "../../img/confirmation/check.svg";

const Confirmation = ({ticketId, onModalOpen}) => {
    const [ticketPatientLastName, setTicketPatientLastName] = useState('')
    const [ticketPatientSecondName, setTicketPatientSecondName] = useState('')
    const [ticketPatientName, setTicketPatientName] = useState('')
    const [ticketPatientPhone, setTicketPatientPhone] = useState('')
    const [inputError, setInputError] = useState('')
    const [isPhoneFilled, setIsPhoneFilled] = useState(false)
    const [agreement, setAgreement] = useState(false)
    const [disabled, setDisabled] = useState(true)
    // const [error, setError] = useState('')
    const phoneRef = useRef(null)

    const onInputChange = (setter, value) => {
        setter(value)
        clearInputError()
    }

    const onPhoneChange = e => {
        const _value = e.target.value
        const _isPhoneFilled = !!_value.match(/\+7 \d{3} \d{3}-\d{2}-\d{2}/)
        setIsPhoneFilled(_isPhoneFilled)
        setTicketPatientPhone(_value)
    }

    const clearInputError = () => {
        setInputError('')
    }

    const clearPhoneError = () => {
        setInputError('')
    }

    const clearAgreementError = () => {
        setInputError('')
    }

    const checkFields = () => {
        let _error = ''
        if (!ticketPatientLastName) {
            _error = 'Введите фамилию'
        }
        if (!ticketPatientName) {
            _error = 'Введите имя'
        }
        if (!ticketPatientSecondName) {
            _error = 'Введите отчество'
        }
        if (!ticketPatientPhone) {
            _error = 'Введите телефон'
        }
        if (!agreement) {
            _error = 'Необходимо согласие с политикой конфиденциальности'
        }
        setInputError(_error)
        return !!_error
    }

    const confirm = async () => {
        try {
            setDisabled(true)
            window.dispatchEvent(new Event('show-preloader'))
            const action = 'vit:doctor.record.confirm'
            const params = { action }
            if (!!ticketId) {
                params.ticketId = ticketId
            }
            // if (!!patId && patientType === 'self') {
            //     params.patId = patId
            // }
            if (!!ticketPatientLastName) {
                params.ticketPatientLastName = ticketPatientLastName
            }
            params.ticketPatientLastName = ticketPatientLastName || ''
            params.ticketPatientName = ticketPatientName || ''
            params.ticketPatientSecondName = ticketPatientSecondName || ''
            // params.ticketPatientBirthday = ticketPatientBirthday || ''
            params.ticketPatientPhone = ticketPatientPhone || ''
            // params.onlinePayment = payment === 'online'
            const response = await get(params)
            window.dispatchEvent(new Event('hide-preloader'))
            setDisabled(false)
            return response
        } catch (e) {
            console.log(e)
            window.dispatchEvent(new Event('hide-preloader'))
            onModalOpen('error')
            // setError('Пожалуйста, попробуйте выбрать другие параметры')
            setDisabled(false)
            return null
        }
    }

    const onSubmit = async () => {
        if (checkFields() || disabled) return
        // window.scrollTo({
        //     top: 0,
        //     left: 0,
        //     behavior: 'instant',
        // })
        const recordContainer = document.getElementById('record')
        const response = await confirm()
        if (!!response) {
            recordContainer.scrollIntoView()
            onModalOpen('success')
        }
    }

    useEffect(() => {
        if (!phoneRef.current) return

        IMask(phoneRef.current, { mask: '+7 000 000-00-00' })
    }, [phoneRef.current])

    useEffect(() => {
        let _disabled = true
        if (!!agreement && !!ticketPatientName && !!ticketPatientLastName && !!ticketPatientSecondName && !!isPhoneFilled) {
            _disabled = false
        }
        setDisabled(_disabled)
    }, [agreement, ticketPatientName, ticketPatientLastName, ticketPatientSecondName, isPhoneFilled])

    return (
        <div className='vc-confirmation'>
            <div className='vc-confirmation__header'>
                Данные пациента
            </div>
            <div className='vc-confirmation__body'>
                <div className="vc-confirmation__inputs">
                    <label className="vc-confirmation__input-wrapper">
                        <input
                            type="text"
                            name="ticketPatientSecondName"
                            className={`vc-confirmation__input${!!inputError && !ticketPatientSecondName ? ' vc-error' : ''}`}
                            placeholder=" "
                            value={ticketPatientSecondName}
                            onChange={e => onInputChange(setTicketPatientSecondName, e.target.value)}
                            onFocus={() => clearInputError()}
                        />
                        <div className="vc-confirmation__input-ph">Фамилия</div>
                    </label>
                    <label className="vc-confirmation__input-wrapper">
                        <input
                            type="text"
                            name="ticketPatientName"
                            className={`vc-confirmation__input${!!inputError && !ticketPatientName ? ' vc-error' : ''}`}
                            placeholder=" "
                            value={ticketPatientName}
                            onChange={e => onInputChange(setTicketPatientName, e.target.value)}
                            onFocus={() => clearInputError()}
                        />
                        <div className="vc-confirmation__input-ph">Имя</div>
                    </label>
                    <label className="vc-confirmation__input-wrapper">
                        <input
                            type="text"
                            name="ticketPatientLastName"
                            className={`vc-confirmation__input${!!inputError && !ticketPatientLastName ? ' vc-error' : ''}`}
                            placeholder=" "
                            value={ticketPatientLastName}
                            onChange={e =>
                                onInputChange(setTicketPatientLastName, e.target.value)
                            }
                            onFocus={() => clearInputError()}
                        />
                        <div className="vc-confirmation__input-ph">Отчество</div>
                    </label>
                    <label className="vc-confirmation__input-wrapper">
                        <input
                            type="text"
                            name="ticketPatientLastName"
                            className={`vc-confirmation__input${!!inputError && !ticketPatientPhone ? ' vc-error' : ''}`}
                            placeholder=" "
                            ref={phoneRef}
                            onChange={onPhoneChange}
                            onFocus={() => clearPhoneError()}
                        />
                        <div className="vc-confirmation__input-ph">Телефон</div>
                    </label>
                </div>
            </div>
            <div className='vc-confirmation__footer'>
                <div className="vc-confirmation__agreement">
                    <label className="vc-confirmation__checkbox-wrapper">
                        <div className={`vc-confirmation__checkbox${!!inputError && !agreement ? ' vc-error' : ''}`}>
                            <input
                                type="checkbox"
                                name="agreement"
                                className="vc-confirmation__checkbox-input"
                                checked={agreement}
                                onChange={e => onInputChange(setAgreement, e.target.checked)}
                                onFocus={() => clearAgreementError()}
                            />
                            {/*<Svg src={checkIcon} />*/}
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.375 3.5L5.82969 10.0625L2.625 7" stroke="white" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
                            </svg>
                        </div>
                        <div className="vc-confirmation__checkbox-text">
                            Я даю согласие на обработку персональных данных
                        </div>
                    </label>
                </div>
                <div className='vc-confirmation__btn'>
                    <div className='vc-btn' onClick={onSubmit} disabled={disabled}>Записаться на прием</div>
                </div>
            </div>
        </div>
    )
}

export default Confirmation