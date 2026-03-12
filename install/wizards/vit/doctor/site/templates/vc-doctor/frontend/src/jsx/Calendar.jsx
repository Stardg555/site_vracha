import React, { useState, useEffect } from 'react'
import Svg from './Svg'
import arrowIcon from '../../../assets/img/calendar/arrow.svg'

const Calendar = ({ availableDays, fullRecordDays, onSelectDay, selectedDay, isMobile }) => {
    const [activeMonth, setActiveMonth] = useState(null)
    const [title, setTitle] = useState('')
    const [weeks, setWeeks] = useState(null)

    const now = new Date()
    const year = now.getFullYear()
    const month = now.getMonth()

    let startX = 0

    const _onSelectDay = (day) => {
        onSelectDay(day.toLocaleDateString('ru-RU'))
    }

    const prevMonth = () => {
        setActiveMonth(activeMonth - 1)
    }

    const nextMonth = () => {
        setActiveMonth(activeMonth + 1)
    }

    const onTouchStart = (e) => {
        startX = e.touches[0].clientX
    }
    const onTouchEnd = (e) => {
        const deltaX = startX - e.changedTouches[0].clientX
        console.log(deltaX)
        startX = 0
        if (deltaX > 50) {
            nextMonth()
            return
        }
        if (deltaX < -50) {
            prevMonth()
            return
        }
    }
    const onTouchMove = (e) => {
        // console.log(e.touches[0])
    }

    useEffect(() => {
        if (activeMonth === null) return
        const date = new Date(year, activeMonth, 1)
        let monthName = date.toLocaleString('ru', { month: 'long' })
        monthName = monthName.charAt(0).toUpperCase() + monthName.slice(1)
        setTitle(`${monthName} ${year}`)

        let _days = []
        let _weeks = []
        const lastDay = new Date(year, activeMonth + 1, 0)

        const daysInMonth = lastDay.getDate()
        for (let i = 1; i <= daysInMonth; i++) {
            const _date = new Date(year, activeMonth, i)
            const _weekday = _date.getDay()
            if (_weekday === 1) {
                _weeks.push(_days)
                _days = []
            }
            _days.push(_date)
        }
        _weeks.push(_days)
        // заполнить первую неделю до начала
        if (_weeks[0].length < 7) {
            const daysToAdd = 7 - _weeks[0].length
            for (let i = 0; i < daysToAdd; i++) {
                _weeks[0].unshift(new Date(year, activeMonth, 0 - i))
            }
        }
        // заполнить последнюю неделю до конца
        // if (_weeks[_weeks.length - 1].length < 7) {
        //     const daysToAdd = 7 - _weeks[_weeks.length - 1].length
        //     for (let i = 0; i < daysToAdd; i++) {
        //         _weeks[_weeks.length - 1].push(new Date(year, activeMonth + 1, i + 1))
        //     }
        // }
        if (_weeks[_weeks.length - 1].length < 7) {
            const daysToAdd = 7 - _weeks[_weeks.length - 1].length
            for (let i = 0; i < daysToAdd; i++) {
                _weeks[_weeks.length - 1].push(null)
            }
        }
        // привести все месяцы к одной высоте
        if (_weeks.length < 6) {
            for (let i = 0; i < 6 - _weeks.length; i++) {
                _weeks.push([null, null, null, null, null, null, null])
            }
        }
        setWeeks(_weeks)
    }, [activeMonth])

    useEffect(() => {
        setActiveMonth(month)
    }, [])

    return (
        <div
            className={`vc-calendar${isMobile ? ' vc-calendar--mobile' : ''}`}
            onTouchStart={isMobile ? onTouchStart : null}
            onTouchEnd={isMobile ? onTouchEnd : null}
            onTouchMove={isMobile ? onTouchMove : null}
        >
            <div className="vc-calendar__header">
                <div className="vc-calendar__arrow" onClick={prevMonth}>
                    {/*<Svg src={arrowIcon} />*/}
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 3L5 8L10 13" stroke="black" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                    </svg>
                </div>
                <div className="vc-calendar__title">{title}</div>
                <div className="vc-calendar__arrow" onClick={nextMonth}>
                    {/*<Svg src={arrowIcon} />*/}
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 3L5 8L10 13" stroke="black" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                    </svg>
                </div>
            </div>
            <div className="vc-calendar__main">
                <div className="vc-calendar__weekdays">
                    <div className="vc-calendar__weekday">пн</div>
                    <div className="vc-calendar__weekday">вт</div>
                    <div className="vc-calendar__weekday">ср</div>
                    <div className="vc-calendar__weekday">чт</div>
                    <div className="vc-calendar__weekday">пт</div>
                    <div className="vc-calendar__weekday vc-calendar__weekday--weekend">сб</div>
                    <div className="vc-calendar__weekday vc-calendar__weekday--weekend">вс</div>
                </div>
                <div className="vc-calendar__days">
                    {!!weeks &&
                        !!weeks.length &&
                        weeks.map(week => {
                            return week.map((day, index) => {
                                if (!day) return (
                                    <div
                                        className="vc-calendar__day vc-calendar__day--empty"
                                        key={index}
                                    ></div>
                                )
                                const isSelectedDay = day.toLocaleDateString('ru-RU') == selectedDay
                                const isAvailableDay = availableDays?.find(d => d === day.toLocaleDateString('ru-RU'))
                                const isFullRecordDay = fullRecordDays?.find(d => d === day.toLocaleDateString('ru-RU'))
                                const isPastDay = day < now
                                const isWeekend = day.getDay() === 0 || day.getDay() === 6
                                const isInactive = (!!isPastDay || !!isWeekend) && !isAvailableDay
                                return (
                                    <div
                                        className={`vc-calendar__day${isInactive
                                            ? ' vc-calendar__day--inactive'
                                            : isAvailableDay
                                            ? ' vc-calendar__day--available'
                                            : ''}${isSelectedDay
                                            ? ' vc-calendar__day--selected'
                                            : ''}${isFullRecordDay ? ' vc-calendar__day--full' : ''}`}
                                        key={day}
                                        onClick={() => !!isAvailableDay && !isSelectedDay && _onSelectDay(day)}
                                    >
                                        {day.getDate()}
                                    </div>
                                )
                            })
                        })}
                </div>
            </div>
        </div>
    )
}

export default Calendar
