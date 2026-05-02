<?php
class ExportController extends Controller
{
    public function workouts()
    {
        $this->requireLogin();
        $userId = $_SESSION['user_id'];
        $workoutModel = $this->model('Workout');
        $workouts = $workoutModel->findAll(['user_id' => $userId], 'date DESC');

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="treninzi_' . date('Y-m-d') . '.csv"');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM za Excel
        fputcsv($out, ['ID', 'Datum', 'Trajanje (min)', 'Napomene'], ';');
        foreach ($workouts as $w) {
            fputcsv($out, [$w['id'], $w['date'], $w['duration_minutes'], $w['notes'] ?? ''], ';');
        }
        fclose($out);
        exit;
    }

    public function measurements()
    {
        $this->requireLogin();
        $userId = $_SESSION['user_id'];
        $measurementModel = $this->model('Measurement');
        $measurements = $measurementModel->findAll(['user_id' => $userId], 'date DESC');

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="merenja_' . date('Y-m-d') . '.csv"');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM za Excel
        fputcsv($out, ['Datum', 'Težina (kg)', 'Mast (%)', 'Struk (cm)', 'Grudi (cm)', 'Ruka (cm)'], ';');
        foreach ($measurements as $m) {
            fputcsv($out, [
                $m['date'],
                $m['weight'] ?? '',
                $m['body_fat_percentage'] ?? '',
                $m['waist_cm'] ?? '',
                $m['chest_cm'] ?? '',
                $m['arm_cm'] ?? ''
            ], ';');
        }
        fclose($out);
        exit;
    }
}
