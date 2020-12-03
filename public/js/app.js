var app = angular.module('myApp', []);
app.controller('FormCtrl', ['$scope', '$http', ($scope, $http) => {

    $scope.data = {};
    $scope.error = {};
    $scope.temp_data = {
        days: {}
    };
    $scope.days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
    $scope.api_config = {
        base_url: "http://localhost:8000/api/",
        version: "v1/",
        endpoints: {
            events: "events"
        }
    };
    $calendar = [];
    $scope.config = {
        success: false
    };

    $scope.store = async () => {


        await $scope.populatePostData();

        await $http.post(`${$scope.api_config.base_url}${$scope.api_config.version}${$scope.api_config.endpoints.events}`, $scope.data)
            .then(async (result) => await $scope.success(result.data.data))
            .catch(async (error) => await $scope.catchError(error.data));

    }

    $scope.populatePostData = async () => {

        $scope.data.date_from = $scope.formatDate($scope.temp_data.date_from);
        $scope.data.date_to = $scope.formatDate($scope.temp_data.date_to);
        $scope.data.days = [];

        angular.forEach($scope.temp_data.days, async (selected, day) => {

            if (selected) {
                $scope.data.days.push(day);
            }
        });

    }

    /**
     * @param {String} str - The date
     */
    $scope.formatDate = (str) => {

        var date = new Date(str),
            mnth = ("0" + (date.getMonth() + 1)).slice(-2),
            day = ("0" + date.getDate()).slice(-2);

        return [date.getFullYear(), mnth, day].join("-");
    }

    /**
     * @param {Object} data - The data
     */
    $scope.success = async (data) => {
        var date_from = $scope.temp_data.date_from;
        var date_to = $scope.temp_data.date_to;

        $scope.calendar = $scope.initializeCalendar({year: date_from.getFullYear(), month: date_from.getMonth()}, {
            year: date_to.getMonth() == 11 ? (date_from.getFullYear() + 1) : date_to.getFullYear(),
            month: date_to.getMonth() == 11 ? 0 : date_to.getMonth() + 1
        }, data.event_schedules, data.name);
        $scope.error = {};
        $scope.config.success = true;

    }

    /**
     * @param {Object} data - The data
     */
    $scope.catchError = async (data) => {
        $scope.error = data;
    }

    /**
     * @param {Object} date_to - The date_to
     * @param {Object} date_from - The date_from
     * @param {Array} event_schedules - The event_schedules
     * @param {String} event_name - The event_name
     */
    $scope.initializeCalendar = (date_from, date_to, event_schedules, event_name) => {

        let dates = [],
            result = {},
            ed = dateFns.eachDay(
                new Date(date_from.year, date_from.month, 1), (new Date(date_to.year, date_to.month, 0))
            );

        ed.forEach((value, key) => {
            let event = {};
            var day = ("0" + (value.getDate())).slice(-2),
                month = ("0" + (value.getMonth() + 1)).slice(-2)
            year = value.getFullYear(),
                date = `${year}-${month}-${day}`;
            if (event_schedules && event_schedules.find(el => el.date == date)) {
                event = {
                    name: event_name,
                    valid: true
                }
            }

            dates.push(
                {
                    date: date,
                    date_obj: {
                        day: day,
                        month: month,
                        year: year,
                        month_name: value.toLocaleString('default', {month: 'long'}),
                        day_name: value.toString().split(' ')[0],
                    },
                    event: event
                }
            );

        });


        let fn = (year, month, month_name, o = result, array = dates) => {
            o[year][month] = {
                [month_name]: array.filter(({date: d}) => `${year}-${month}` === d.slice(0, 7))
            };

        }

        for (let value of dates) {

            if (!result[value.date_obj.year]) result[value.date_obj.year] = {};
            fn(value.date_obj.year, value.date_obj.month, value.date_obj.month_name);
        }

        let calendar = [];
        for (var y of Object.keys(result)) {

            let input = {
                year: y,
                months: {}
            };
            let month_keys = [];
            for (var tm of Object.keys(result[y])) {
                month_keys.push(tm);
            }
            month_keys.sort().forEach((value, key) => {
                for (var m of Object.keys(result[y][value])) {
                    input.months[m] = result[y][value][m]
                }

            });
            calendar.push(input);
        }

        return calendar;

    }

    var init = () => {

        let date = new Date(),
            year = date.getFullYear()
        month = date.getMonth();

        $scope.calendar = $scope.initializeCalendar({year: year, month: month}, {
            year: month == 11 ? (year + 1) : year,
            month: month == 11 ? 0 : month
        });
    }
    init();
}]);

