import React from 'react'
// import Svg from "../Svg";
// import closeIcon from "../../img/modal/close.svg";

const Modal = ({ active, success, onClose }) => {

    if (!success) return (
        <div className={`vc-modal ${active ? "vc-modal--active" : " "}`} data-name="confirmationError">
            <div className="vc-modal__container">
                <div className="vc-modal__header">
                    <div className="vc-modal__title-wrapper">
                        <div className="vc-modal__title">Возникла ошибка при подтверждении записи</div>
                    </div>
                </div>
                <div className="vc-modal__content">
                    <div className="vc-record-form">
                        <div className="vc-modal__subtitle">Пожалуйста, попробуйте выбрать другие параметры</div>
                        <div className="vc-record-form__submit-wrapper">
                            <div className="vc-btn" onClick={onClose}>Вернуться к записи</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )

    return (
        <div className={`vc-modal ${active ? "vc-modal--active" : " "}`}>
            <div className="vc-modal__container">
                <div className="vc-modal__success">
                    <div className="vc-modal__success-header">
                        <div className="vc-modal__success-title">
                            Ваша заявка успешно отправлена
                        </div>
                        <div className="vc-modal__success-close" onClick={onClose}>
                            {/*<Svg src={closeIcon} />*/}
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M15 1L1 15" stroke="#788D98" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
                                <path d="M15 15L1 1" stroke="#788D98" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <div className="vc-modal__success-main">
                        <div className="vc-modal__success-subtitle">
                            Наш администратор свяжется с вами в ближайшее время для подтверждения записи. Ожидайте звонка.
                        </div>
                    </div>
                    <div className="vc-modal__success-footer">
                        <div className="vc-btn" onClick={onClose}>OK</div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Modal