import React, { Component } from 'react';
import ReactDOM from "react-dom";

export default class Resume extends React.Component {
    render() {
        return (
            <React.Fragment>
                <ContactsData cities={this.props.cities} />
                <BasicInformation />
                <button className="btn btn-primary" type="submit">Сохранить и опубликовать</button>
            </React.Fragment>
        );
    };
}

$(document).ready(function() {
    let cities = (typeof resumeCities !== "undefined" && resumeCities instanceof Array) ? resumeCities : [],
        specializations = (typeof resumeSpecializations !== "undefined" && resumeSpecializations instanceof Array) ? resumeSpecializations : [];

    if (document.getElementById('page_resume')) {
        ReactDOM.render(<Resume cities={cities} specializations={specializations} />, document.getElementById('page_resume'));
    }
});

const ContactsData = (props) => {
    const cities = props.cities.map( (item) => (<option key={item.id} value={item.id}>{item.name}</option>) );

    return (
        <React.Fragment>
            <h5 className="mb-3">Контактные данные</h5>
            <div className="mb-5 ml-2">
                <div className="form-group row">
                    <div className="col-lg-2">Имя</div>
                    <div className="col-7 col-lg-4">
                        <input name="first_name" type="text" className="form-control form-control-sm" />
                    </div>
                </div>
                <div className="form-group row">
                    <div className="col-lg-2">Фамилия</div>
                    <div className="col-7 col-lg-4">
                        <input name="last_name" type="text" className="form-control form-control-sm" />
                    </div>
                </div>
                <div className="form-group row">
                    <div className="col-lg-3">Город проживания</div>
                    <div className="col-7 col-lg-3">
                        <select name="city_id" className="form-control form-control-sm">
                            <option value="0">Не выбрано</option>
                            {cities}
                        </select>
                    </div>
                </div>
            </div>
        </React.Fragment>
    );
};

const BasicInformation = (props) => {
    return (
        <React.Fragment>
            <h5 className="mb-3">Основная информация</h5>
            <div className="mb-5 ml-2">
                <div className="form-group row">
                    <div className="col-lg-2">Дата рождения</div>
                    <div className="col-auto">
                        <input name="birthday" type="date" className="form-control form-control-sm" />
                    </div>
                </div>
                <div className="form-group row">
                    <div className="col-lg-2">Пол</div>
                    <div className="col-7 col-lg-4">
                        <div className="custom-control custom-radio">
                            <input type="radio" id="genderM" name="gender" value="M" className="custom-control-input" />
                            <label className="custom-control-label" htmlFor="genderM">Мужской</label>
                        </div>
                        <div className="custom-control custom-radio">
                            <input type="radio" id="genderW" name="gender" value="W" className="custom-control-input" />
                            <label className="custom-control-label" htmlFor="genderW">Женский</label>
                        </div>
                    </div>
                </div>
                <div className="form-group row">
                    <div className="col-lg-2">Опыт работы</div>
                    <div className="col-7 col-lg-4">
                        <div className="custom-control custom-radio">
                            <input type="radio" id="hasExperienceYes" name="hasExperience"
                                   className="custom-control-input" />
                            <label className="custom-control-label" htmlFor="hasExperienceYes">Есть опыт
                                    работы</label>
                        </div>
                        <div className="custom-control custom-radio">
                            <input type="radio" id="hasExperienceNo" name="hasExperience"
                                   className="custom-control-input" />
                            <label className="custom-control-label" htmlFor="hasExperienceNo">Нет опыта
                                    работы</label>
                        </div>
                    </div>
                </div>
            </div>
        </React.Fragment>
    );
};




