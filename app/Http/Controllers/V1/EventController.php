<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EventController extends Controller {


	/**
	 * @var Event
	 */
	private $event;
	/**
	 * @var DB
	 */
	private $DB;

	public function __construct(Event $event) {

		$this->event = $event;
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse|object
	 */
	public function index(Request $request) {

		$data = $request->all();

		$result = $this->event->with(['eventSchedules'])->get();

		return (new EventResource($result))->response()->setStatusCode(Response::HTTP_OK);
	}

	/**
	 * @param EventRequest $request
	 * @return \Illuminate\Http\JsonResponse|object
	 */
	public function store(EventRequest $request) {

		$data = $request->all();

		$data['schedules'] = $this->populateDates($data['date_from'], $data['date_to'], $data['days']);

		$result = DB::transaction(function () use ($data) {
			$event = $this->event->create($data);
			$event->eventSchedules()->createMany($data['schedules']);

			return $event;

		});

		return (new EventResource($result))->response()->setStatusCode(Response::HTTP_CREATED);
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|object
	 */
	public function show($id) {

		$result = $this->event->with(['eventSchedules'])->find($id);

		return (new EventResource($result))->response()->setStatusCode(Response::HTTP_OK);
	}

	/**
	 * @param string $from
	 * @param string $to
	 * @param array $days
	 * @return array
	 */
	public function populateDates(string $from, string $to, array $days): array {

		$data = [];
		$iDate = date(config('constants.date_format'), strtotime($from));

		do {

			if (in_array(date('D', strtotime($iDate)), $days)) {
				$data[] = ['date' => $iDate];
			}

			$iDate = date(config('constants.date_format'), strtotime($iDate . ' + 1 day'));

		} while ($iDate <= $to);

		return $data;
	}

}
