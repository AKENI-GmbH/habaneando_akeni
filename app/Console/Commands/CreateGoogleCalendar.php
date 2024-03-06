<?php

namespace App\Console\Commands;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_AclRule;
use Google_Service_Calendar_AclRuleScope;
use Illuminate\Console\Command;

class CreateGoogleCalendar extends Command
{
    protected $signature = 'calendar:create';
    protected $description = 'Create or update a Google Calendar';

    public function handle()
    {
        $client = new Google_Client();
        $credentialsJson = base64_decode(env('GOOGLE_CREDENTIALS_BASE64'));
        $client->setAuthConfig(json_decode($credentialsJson, true));

        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $calendarService = new Google_Service_Calendar($client);

        $calendarId = null;

        // Check if a calendar with the same summary already exists
        $calendars = $calendarService->calendarList->listCalendarList();
        foreach ($calendars->getItems() as $cal) {
            if ($cal->getSummary() === 'Habaneando Tanzschule') {
                $calendarId = $cal->getId();
                $this->info('Calendar already exists. ID: ' . $calendarId);
                break;
            }
        }

        // Create a new calendar if it doesn't exist
        if (!$calendarId) {
            $calendar = new Google_Service_Calendar_Calendar();
            $calendar->setSummary('Habaneando Tanzschule');
            $calendar->setTimeZone('Europe/Berlin');

            try {
                $createdCalendar = $calendarService->calendars->insert($calendar);
                $calendarId = $createdCalendar->getId();
                $this->info('Calendar created successfully. ID: ' . $calendarId);
            } catch (\Exception $e) {
                $this->error('Error creating calendar: ' . $e->getMessage());
                return;
            }
        }

        // Function to share calendar with an email
        $shareCalendar = function ($email) use ($calendarService, $calendarId) {
            $rule = new Google_Service_Calendar_AclRule();
            $scope = new Google_Service_Calendar_AclRuleScope();
            $scope->setType('user');
            $scope->setValue($email);
            $rule->setScope($scope);
            $rule->setRole('editor');
            try {
                $calendarService->acl->insert($calendarId, $rule);
            } catch (\Exception $e) {
                $this->error('Error sharing calendar with ' . $email . ': ' . $e->getMessage());
            }
        };

        $shareCalendar('info@habaneando.com');
        $shareCalendar('katy@habaneando.com');
        $this->info('Calendar shared successfully with specified accounts.');
    }
}
