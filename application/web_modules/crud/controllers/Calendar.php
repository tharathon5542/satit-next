<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    private function mainVariable()
    {
        $reponse['title'] = 'CRRU-CWIE | MIS';
        $reponse['description'] = 'CWIE';
        $reponse['author'] = 'CLLI Devs';
        return $reponse;
    }

    private function checkPermission($acceptPermissionList = [])
    {
        if (!in_array($this->session->userdata('crudSessionData')['crudPermission'], $acceptPermissionList))
            return false;
        return true;
    }

    /*
    | --------------------------------------------------------------------------------
    | Load View Section
    | --------------------------------------------------------------------------------
    */

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getCalendarEvents($authID = null)
    {

        if ($authID != null && $this->session->userdata('crudSessionData')['crudPermission'] != 'admin') {
            // query calendar events
            $queryCalendarEvents = $this->db->get_where('cwie_calendar_events', array('auth_id' => $authID));

            foreach ($queryCalendarEvents->result() as $event) {
                // get event color
                $queryEventColor = $this->db->select('faculty_event_color')->get_where('cwie_faculty', array('auth_id' => $event->auth_id));
                $eventColor = $queryEventColor->row()->faculty_event_color;
                $queryData[] = [
                    'eventId' => $event->calendar_event_id,
                    'eventTitle' => $event->calendar_event_title,
                    'eventDetail' => $event->calendar_event_detail,
                    'eventPlace' => $event->calendar_event_place,
                    'eventStart' => $event->calendar_event_start,
                    'eventEnd' => $event->calendar_event_end,
                    'eventTimeStart' => $event->calendar_event_time_start,
                    'eventTimeEnd' => $event->calendar_event_time_end,
                    'eventOwner' => $event->calendar_event_owner,
                    'eventAuthID' => $event->auth_id,
                    'eventColor' => $eventColor
                ];
            }
            header('Content-Type: application/json');
            echo json_encode(['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
            return;
        }

        // query calendar events
        $queryCalendarEvents = $this->db->get('cwie_calendar_events');

        foreach ($queryCalendarEvents->result() as $event) {

            // get event color
            $eventColor = '';
            $queryAuthData = $this->db->select('auth_type')->get_where('cwie_authentication', array('auth_id' => $event->auth_id));
            switch ($queryAuthData->row()->auth_type) {
                case 0: // 0 = admin
                    $eventColor = '#06ADCE';
                    break;
                case 1: // 1 = faculty
                    $queryEventColor = $this->db->select('faculty_event_color')->get_where('cwie_faculty', array('auth_id' => $event->auth_id));
                    $eventColor = $queryEventColor->row()->faculty_event_color;
                    break;
            }

            $queryData[] = [
                'eventId' => $event->calendar_event_id,
                'eventTitle' => $event->calendar_event_title,
                'eventDetail' => $event->calendar_event_detail,
                'eventPlace' => $event->calendar_event_place,
                'eventStart' => $event->calendar_event_start,
                'eventEnd' => $event->calendar_event_end,
                'eventTimeStart' => $event->calendar_event_time_start,
                'eventTimeEnd' => $event->calendar_event_time_end,
                'eventOwner' => $event->calendar_event_owner,
                'eventAuthID' => $event->auth_id,
                'eventColor' => $eventColor
            ];
        }

        header('Content-Type: application/json');
        echo json_encode(['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddCalendarEvent()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate calendarEventName
        $this->form_validation->set_rules('calendarEventName', '', 'trim|required');
        // validate calendarEventDetail
        $this->form_validation->set_rules('calendarEventDetail', '', 'trim');
        // validate calendarEventPlace
        $this->form_validation->set_rules('calendarEventPlace', '', 'trim');
        // validate calendarEventStart
        $this->form_validation->set_rules('calendarEventStart', '', 'trim|required');
        // validate calendarEventEnd
        $this->form_validation->set_rules('calendarEventEnd', '', 'trim|required');
        // validate calendarEventStartTime
        $this->form_validation->set_rules('calendarEventStartTime', '', 'trim');
        // validate calendarEventEndTime
        $this->form_validation->set_rules('calendarEventEndTime', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post calendar event variable with xss clean
        $calendarEventTitle = $this->input->post('calendarEventName', true);
        $calendarEventDetail = $this->input->post('calendarEventDetail', true) ? $this->input->post('calendarEventDetail', true) : null;
        $calendarEventPlace = $this->input->post('calendarEventPlace', true) ? $this->input->post('calendarEventPlace', true) : null;
        $calendarEventStart = $this->input->post('calendarEventStart', true) ? $this->input->post('calendarEventStart', true) : null;
        $calendarEventEnd = $this->input->post('calendarEventEnd', true) ? $this->input->post('calendarEventEnd', true) : null;
        $calendarEventStartTime = $this->input->post('calendarEventStartTime', true) ? $this->input->post('calendarEventStartTime', true) : null;
        $calendarEventEndTime = $this->input->post('calendarEventEndTime', true) ? $this->input->post('calendarEventEndTime', true) : null;
        $calendarOwner = $this->session->userdata('crudSessionData')['crudPermission'] == 'admin' ? ' สถาบันการเรียนรู้ตลอดชีวิต' : $this->session->userdata('crudSessionData')['crudName'] . ' ' . (isset($this->session->userdata('crudSessionData')['crudSurname']) ? $this->session->userdata('crudSessionData')['crudSurname'] : '');

        // faculty insert data
        $calendarEventInsertData = [
            'calendar_event_title' => $calendarEventTitle,
            'calendar_event_detail' => $calendarEventDetail,
            'calendar_event_place' => $calendarEventPlace,
            'calendar_event_start' => $calendarEventStart,
            'calendar_event_end' => $calendarEventEnd,
            'calendar_event_time_start' => $calendarEventStartTime,
            'calendar_event_time_end' => $calendarEventEndTime,
            'calendar_event_owner' => $calendarOwner,
            'auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']
        ];

        if (!$this->db->insert('cwie_calendar_events', $calendarEventInsertData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true, 'message' => 'เพิ่มข้อมูลกิจกรรมแล้ว']);
    }

    public function onEditCalendarEventDetail($eventID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if faculty id not set
        if ($eventID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate calendarEventName
        $this->form_validation->set_rules('calendarEventName', '', 'trim|required');
        // validate calendarEventDetail
        $this->form_validation->set_rules('calendarEventDetail', '', 'trim');
        // validate calendarEventPlace
        $this->form_validation->set_rules('calendarEventPlace', '', 'trim');
        // validate calendarEventStartTime
        $this->form_validation->set_rules('calendarEventStartTime', '', 'trim');
        // validate calendarEventEndTime
        $this->form_validation->set_rules('calendarEventEndTime', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post calendar event variable with xss clean
        $calendarEventTitle = $this->input->post('calendarEventName', true);
        $calendarEventDetail = $this->input->post('calendarEventDetail', true) ? $this->input->post('calendarEventDetail', true) : null;
        $calendarEventPlace = $this->input->post('calendarEventPlace', true) ? $this->input->post('calendarEventPlace', true) : null;
        $calendarEventStartTime = $this->input->post('calendarEventStartTime', true) ? $this->input->post('calendarEventStartTime', true) : null;
        $calendarEventEndTime = $this->input->post('calendarEventEndTime', true) ? $this->input->post('calendarEventEndTime', true) : null;

        // calendar event update data
        $calendarEventData = [
            'calendar_event_title' => $calendarEventTitle,
            'calendar_event_detail' => $calendarEventDetail,
            'calendar_event_place' => $calendarEventPlace,
            'calendar_event_time_start' => $calendarEventStartTime,
            'calendar_event_time_end' => $calendarEventEndTime,
        ];

        if (!$this->db->update('cwie_calendar_events', $calendarEventData, array('calendar_event_id' => $eventID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode(['status' => 'true', 'message' => 'แก้ไขรายละเอียดกิจกรรมแล้ว', 'csrfName' => $this->security->get_csrf_token_name(), 'cstfHash' => $this->security->get_csrf_hash()]);
    }

    public function onEventDrop()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate eventID
        $this->form_validation->set_rules('eventID', '', 'trim|required');
        // validate evertStart
        $this->form_validation->set_rules('eventStart', '', 'trim|required');
        // validate evertEnd
        $this->form_validation->set_rules('eventStart', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post event variable with xss clean
        $eventId = $this->input->post('eventID', true);
        $dateStart = $this->input->post('eventStart', true);
        $dateEnd = $this->input->post('eventEnd', true);

        // event update data
        $calendarEventUpdateDate = [
            'calendar_event_start' => $dateStart,
            'calendar_event_end' => $dateEnd,
        ];

        if (!$this->db->update('cwie_calendar_events', $calendarEventUpdateDate, array('calendar_event_id' => $eventId))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true, 'message' => 'แก้ไขข้อมูลวันที่ของกิจกรรมแล้ว']);
    }

    public function onEventResize()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate eventID
        $this->form_validation->set_rules('eventID', '', 'trim|required');
        // validate evertStart
        $this->form_validation->set_rules('eventEnd', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post event variable with xss clean
        $eventId = $this->input->post('eventID', true);
        $dateEnd = $this->input->post('eventEnd', true);

        // faculty insert data
        $calendarEventUpdateDate = [
            'calendar_event_end' => $dateEnd,
        ];

        if (!$this->db->update('cwie_calendar_events', $calendarEventUpdateDate, array('calendar_event_id' => $eventId))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true, 'message' => 'แก้ไขข้อมูลวันที่ของกิจกรรมแล้ว']);
    }

    public function onDeleteCalendarEvents($eventID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($eventID == null) {
            $response = ['status' => false, 'errorMessage' => 'Parameter Not Found!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // delete event
        if (!$this->db->delete('cwie_calendar_events', array('calendar_event_id' => $eventID))) {
            $response = ['status' => false, 'errorMessage' => 'DB Error! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true, 'message' => 'ทำการลบข้อมูลกิจกรรมแล้ว']);
    }
}
