<?php
class ImportController extends Controller
{
    public function workouts()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_FILES['csv_file']['tmp_name'])) {
                $this->setFlash('Izaberi CSV fajl.', 'danger');
                $this->redirect('/import/workouts');
            }

            $file = $_FILES['csv_file']['tmp_name'];
            $handle = fopen($file, 'r');
            if (!$handle) {
                $this->setFlash('Greška pri čitanju fajla.', 'danger');
                $this->redirect('/import/workouts');
            }

            // Preskoci header red
            fgetcsv($handle, 0, ';');

            $workoutModel = $this->model('Workout');
            $imported = 0;
            while (($row = fgetcsv($handle, 0, ';')) !== false) {
                if (empty($row[0])) continue; // datum je obavezan
                $workoutModel->create([
                    'user_id'          => $_SESSION['user_id'],
                    'date'             => $row[0],
                    'duration_minutes' => !empty($row[1]) ? (int) $row[1] : 0,
                    'notes'            => $row[2] ?? ''
                ]);
                $imported++;
            }
            fclose($handle);

            $this->setFlash("Uvezeno $imported treninga.", 'success');
            $this->redirect('/workouts');
        }

        $this->render('import/workouts', ['title' => 'Uvezi treninge']);
    }

    public function measurements()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_FILES['csv_file']['tmp_name'])) {
                $this->setFlash('Izaberi CSV fajl.', 'danger');
                $this->redirect('/import/measurements');
            }

            $file = $_FILES['csv_file']['tmp_name'];
            $handle = fopen($file, 'r');
            if (!$handle) {
                $this->setFlash('Greška pri čitanju fajla.', 'danger');
                $this->redirect('/import/measurements');
            }

            // Preskoci header red
            fgetcsv($handle, 0, ';');

            $measurementModel = $this->model('Measurement');
            $imported = 0;
            while (($row = fgetcsv($handle, 0, ';')) !== false) {
                if (empty($row[0])) continue; // datum je obavezan
                $measurementModel->create([
                    'user_id'             => $_SESSION['user_id'],
                    'date'                => $row[0],
                    'weight'              => !empty($row[1]) ? (float) $row[1] : null,
                    'body_fat_percentage' => !empty($row[2]) ? (float) $row[2] : null,
                    'waist_cm'            => !empty($row[3]) ? (float) $row[3] : null,
                    'chest_cm'            => !empty($row[4]) ? (float) $row[4] : null,
                    'arm_cm'              => !empty($row[5]) ? (float) $row[5] : null,
                ]);
                $imported++;
            }
            fclose($handle);

            $this->setFlash("Uvezeno $imported merenja.", 'success');
            $this->redirect('/measurements');
        }

        $this->render('import/measurements', ['title' => 'Uvezi merenja']);
    }
}
