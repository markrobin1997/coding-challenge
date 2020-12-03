<!DOCTYPE html>
<html>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
      integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<body>

<div ng-app="myApp" ng-controller="FormCtrl" class="container">


    <form name="appForm" role="form" ng-submit="store()">
        <div class="row mt-5">
            <div class="col-sm-12">
                <h1>CALENDAR</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <label>Event</label>
                        <input type="text" ng-model="data.name" class="form-control"
                               ng-class="{'border-danger': error.errors.name[0]}">
                        <small ng-if="error.errors.name[0]" class="text-danger">@{{ error.errors.name[0] }}</small>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-6">
                        <label>From</label>
                        <input type="date" ng-model="temp_data.date_from" class="form-control"
                               ng-class="{'border-danger': error.errors.date_from[0]}">
                        <small ng-if="error.errors.date_from[0]" class="text-danger">@{{ error.errors.date_from[0]
                            }}</small>
                    </div>
                    <div class="col-sm-6">
                        <label>To</label>
                        <input type="date" ng-model="temp_data.date_to" class="form-control"
                               ng-class="{'border-danger': error.errors.date_to[0]}">
                        <small ng-if="error.errors.date_to[0]" class="text-danger">@{{ error.errors.date_to[0]
                            }}</small>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-lg-12">
                        <label class="">Days</label>
                    </div>
                    <div class="col" ng-repeat="(key,value) in days">

                        <div class="form-check">
                            <input type="checkbox" ng-model="temp_data.days[value]" class="form-check-input">
                            <label class="form-check-label"> @{{value}}</label>
                        </div>

                    </div>
                    <div class="col-lg-12" ng-if="error.errors.days[0]">
                        <small class="text-danger">@{{ error.errors.days[0] }}</small>
                    </div>
                </div>
                <div class="row mt-3" ng-if="error.message">
                    <div class="col-lg-12">
                        <div class="alert alert-danger mb-0">@{{ error.message }}</div>
                    </div>
                </div>
                <div class="row mt-3" ng-if="config.success">
                    <div class="col-lg-12">
                        <div class="mb-0 alert alert-success alert-dismissible fade show" role="alert">
                            Event successfully saved.
                            <button type="button" ng-click="config.success = false" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary btn-block">SAVE</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row mb-3" ng-repeat="(year,yvalue) in calendar">
                    <div class="col-lg-12">
                        <h2>@{{yvalue.year}}</h2>
                        <hr>
                        <div class="row" ng-repeat="(month,mvalue) in yvalue.months">
                            <div class="col-lg-12">
                                <table class="table table-borded">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th colspan="2">@{{month}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="(key,value) in mvalue"
                                        ng-class="{'table-success': value.event.valid}">
                                        <td>@{{value.date_obj.day}} @{{value.date_obj.day_name}}</td>
                                        <td>@{{ value.event.name }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/date-fns/1.29.0/date_fns.min.js"></script>
<script src="./js/app.js"></script>

</body>
</html>
