import React, { useState, useEffect, useRef } from 'react'
import Calendar from '../Calendar'
import { FTScroller } from 'ftscroller'

const Schedule = ({ depList, selectedServ, onTimeClick, serviceType }) => {
    const [days, setDays] = useState(null)
    const [availableDays, setAvailableDays] = useState(null)
    const [selectedDay, setSelectedDay] = useState(null)
    const [branches, setBranches] = useState(null)
    const [selectedBranch, setSelectedBranch] = useState(null)
    const [activeSwitch, setActiveSwitch] = useState(0)
    const [nextAvailableDay, setNextAvailableDay] = useState('')
    const [noAvailableDay, setNoAvailableDay] = useState(false)
    const daysRef = useRef(null)

    const switches = [
        {
            id: 0,
            title: 'Неделю',
        },
        {
            id: 1,
            title: 'Месяц',
        },
    ]

    const BranchesScroller = ({ branches, onSelectBranch, selectedBranch }) => {
        const branchesRef = useRef(null)

        useEffect(() => {
            if (!branchesRef.current) return
            const scroller = new FTScroller(branchesRef.current, {
                scrollbars: false,
                scrollingY: false,
                bouncing: false,
            })
            return () => {
                scroller.destroy()
            }
        }, [branchesRef])

        if (!branches || !branches.length) return null

        return (
            <div className="vc-record__branches-wrapper" ref={branchesRef}>
                <div className="vc-record__branches">
                    {branches.map(branch => (
                        <div
                            className={`vc-record__branch${selectedBranch?.ID === branch.ID ? ' vc-record__branch--active' : ''}`}
                            key={branch.ID}
                            onClick={() => onSelectBranch(branch)}
                        >
                            {branch.NAME}
                        </div>
                    ))}
                </div>
            </div>
        )
    }

    const onSelectBranch = branch => {
        if (selectedBranch?.ID === branch.ID) {
            if (branches.length !== 1) {
                setSelectedBranch(null)
            }
            return
        }
        setSelectedBranch(branch)
    }

    const onSelectDayCalendar = dateString => {
        setSelectedDay(days.find(day => day.dateString === dateString))
    }

    const onSelectDay = day => {
        setSelectedDay(day)
    }

    const getPeriods = ({day, dep}) => {
        let _periods = []
        day.PERIODS.forEach(period => {
            const start = period.START_PERIOD_TIMESTAMP
            const end = period.END_PERIOD_TIMESTAMP
            const duration = selectedServ?.DURATION || period.DURATION
            const _daySchedule = new Date(day.DAY.DATE_OBJECT)
            const _yearSchedule = _daySchedule.getFullYear()
            const _monthSchedule = _daySchedule.getMonth()
            const _dateSchedule = _daySchedule.getDate()
            const _now = new Date()
            const _nowYear = _now.getFullYear()
            const _nowMonth = _now.getMonth()
            const _nowDate = _now.getDate()
            const _todayIsTheDay =
                _nowYear === _yearSchedule &&
                _nowMonth === _monthSchedule &&
                _nowDate === _dateSchedule

            for (let i = 0; i < (end - start) / duration; i++) {
                const _start = new Date((start + duration * i) * 1000)
                const _end = new Date((start + duration * (i + 1)) * 1000)
                if (_now > _start && _todayIsTheDay) continue
                _periods.push({
                    start: _start,
                    end: _end,
                    depId: dep.ID,
                })
            }
        })

        if (day.TICKETS && !!day.TICKETS.length) {
            _periods = _periods.filter(period => {
                return !day.TICKETS.some(ticket => {
                    return (
                        (period.start >= new Date(ticket.START_VISIT) &&
                            period.start < new Date(ticket.END_VISIT)) ||
                        (period.end > new Date(ticket.START_VISIT) &&
                            period.end <= new Date(ticket.END_VISIT))
                    )
                })
            })
        }
        return _periods
    }

    useEffect(() => {
        if (!selectedDay) return
        let _branches = depList.filter(dep => {
            return Object.values(dep.DAYS).find(
                day => day.DAY.DATE_OBJECT === selectedDay.DATE_OBJECT,
            )
        })
        if (!selectedDay.periods.length) {
            setBranches(null)
            setSelectedBranch(null)
            const _nextAvailableDay = days.find(day => day.periods.length)
            !!_nextAvailableDay && setNextAvailableDay(_nextAvailableDay)
            !_nextAvailableDay && setNoAvailableDay(true)
            return
        }
        // убрать те филиалы, где нет свободных ячеек
        _branches = _branches.filter(dep => {
            return !!selectedDay.periods.find(p => p.depId == dep.ID)
        })
        // ------------------------------------------
        setNextAvailableDay(null)
        setNoAvailableDay(false)
        setBranches(_branches)
        setSelectedBranch(_branches.length === 1 ? _branches[0] : null)
    }, [selectedDay])

    useEffect(() => {
        if (!days) return
        setSelectedDay(days[0])
    }, [days])

    useEffect(() => {
        if (!depList) return
        let _days = []
        depList.forEach(dep => {
            if (!dep.DAYS) return
            Object.values(dep.DAYS).forEach(day => {
                if (_days.find(d => d.DATE_OBJECT === day.DAY.DATE_OBJECT)) return
                const _day = day.DAY
                _day.TIMESTAMP = new Date(_day.DATE_OBJECT)
                _day.dateString = _day.TIMESTAMP.toLocaleDateString('ru-RU')
                _day.periods = getPeriods({day, dep})
                _day.textDate = _day.TIMESTAMP.toLocaleString('ru-RU', {
                    day: 'numeric',
                    month: 'long',
                })
                _days.push(_day)
            })
        })
        _days = _days.sort((a, b) => {
            if (a.TIMESTAMP < b.TIMESTAMP) return -1
            if (a.TIMESTAMP > b.TIMESTAMP) return 1
            return 0
        })
        setDays(_days)
        setAvailableDays(_days.map(day => day.dateString))
    }, [depList, selectedServ])

    useEffect(() => {
        if (!daysRef.current) return
        const scroller = new FTScroller(daysRef.current, {
            scrollbars: false,
            scrollingY: false,
            bouncing: false,
        })
        return () => {
            scroller.destroy()
        }
    }, [daysRef.current])

    if (!depList) return null

    return (
        <div className="vc-record__schedule-wrapper">
            <div className="vc-record__schedule">
                <div className="vc-record__schedule-header">
                    <div className="vc-record__schedule-title">Расписание на</div>
                    <div className="vc-record__schedule-switcher">
                        {switches.map(switchItem => (
                            <div
                                className={`vc-record__schedule-switch${activeSwitch === switchItem.id ? ' vc-record__schedule-switch--active' : ''}`}
                                key={switchItem.id}
                                onClick={() => setActiveSwitch(switchItem.id)}
                            >
                                {switchItem.title}
                            </div>
                        ))}
                    </div>
                </div>
                {activeSwitch === 1 && (
                    <div className="vc-record__calendar-wrapper">
                        <Calendar
                            availableDays={availableDays}
                            onSelectDay={onSelectDayCalendar}
                            selectedDay={selectedDay?.dateString}
                        />
                    </div>
                )}
                {activeSwitch === 0 && (
                    <div className="vc-record__days-wrapper" ref={daysRef}>
                        <div className="vc-record__days">
                            {!!days &&
                                !!days.length &&
                                days.map(day => {
                                    const _splitted = day.DATE_FORMATTED.split(', ')
                                    return (
                                        <div
                                            className={`vc-record__day${selectedDay === day ? ' vc-record__day--active' : ''}`}
                                            key={day.TIMESTAMP}
                                            onClick={() => onSelectDay(day)}
                                        >
                                            <div className="vc-record__day-title">
                                                {_splitted[0]}
                                            </div>
                                            <div className="vc-record__day-subtitle">
                                                {_splitted[1]}
                                            </div>
                                        </div>
                                    )
                                })}
                        </div>
                    </div>
                )}
                {serviceType === 'offline' && (
                    <BranchesScroller
                        branches={branches}
                        onSelectBranch={onSelectBranch}
                        selectedBranch={selectedBranch}
                    />
                )}
                {!!selectedDay?.periods && !!selectedDay.periods.length && (
                    <div className="vc-record__time">
                        {selectedDay.periods.map((period, index) => {
                            if (!!selectedBranch && selectedBranch.ID !== period.depId)
                                return null
                            return (
                                <div
                                    className="vc-record__time-item"
                                    onClick={() =>{
                                        onTimeClick({ period, branch: { ID: period.depId }, serviceType })}
                                    }
                                    key={index}
                                >
                                    {period.start.getHours() < 10
                                        ? `0${period.start.getHours()}`
                                        : period.start.getHours()}
                                    :
                                    {period.start.getMinutes() < 10
                                        ? `0${period.start.getMinutes()}`
                                        : period.start.getMinutes()}
                                </div>
                            )
                        })}
                    </div>
                )}
                {!!nextAvailableDay && selectedDay && (
                    <div className="vc-schedule__empty">
                        Запись на&nbsp;
                        {selectedDay.textDate}&nbsp;
                        завершена.
                        <br />
                        Ближайшая дата для записи&nbsp;
                        <span
                            className="vc-schedule__empty-link"
                            onClick={() => setSelectedDay(nextAvailableDay)}
                        >
                            {nextAvailableDay.textDate}
                        </span>
                        <br />
                        Попробуйте выбрать другой филиал.
                    </div>
                )}
                {!!noAvailableDay && !!selectedDay && (
                    <div className="vc-schedule__empty">
                        Запись на&nbsp;
                        {selectedDay.textDate}&nbsp;
                        завершена.
                        <br />
                        Пожалуйста, выберите другой день.
                    </div>
                )}
            </div>
        </div>
    )
}

export default Schedule
