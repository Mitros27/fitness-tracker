<?php
class MeasurementsController extends Controller
{
    public function index()
    {
        $this->requireLogin();
        $userId = $_SESSION['user_id'];
        $measurementModel = $this->model('Measurement');
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $total = $measurementModel->countByUser($userId);
        $totalPages = ceil($total / ITEMS_PER_PAGE);
        $measurements = $measurementModel->getByUser($userId, $page);
        $this->render('measurements/index', [
            'title' => 'Merenja',
            'measurements' => $measurements,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function create()
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['date'] ?? '';
            if (empty($date)) {
                $this->setFlash('Datum je obavezan.', 'danger');
                $this->redirect('/measurements/create');
            }
            $data = [
                'user_id'            => $_SESSION['user_id'],
                'date'               => $date,
                'weight'             => !empty($_POST['weight']) ? (float) $_POST['weight'] : null,
                'body_fat_percentage'=> !empty($_POST['body_fat_percentage']) ? (float) $_POST['body_fat_percentage'] : null,
                'waist_cm'           => !empty($_POST['waist_cm']) ? (float) $_POST['waist_cm'] : null,
                'chest_cm'           => !empty($_POST['chest_cm']) ? (float) $_POST['chest_cm'] : null,
                'arm_cm'             => !empty($_POST['arm_cm']) ? (float) $_POST['arm_cm'] : null,
            ];
            $measurementModel = $this->model('Measurement');
            $measurementModel->create($data);
            $this->setFlash('Merenje uspešno dodato!', 'success');
            $this->redirect('/measurements');
        }
        $this->render('measurements/create', [
            'title' => 'Novo merenje'
        ]);
    }

    public function delete($id)
    {
        $this->requireLogin();
        $measurementModel = $this->model('Measurement');
        $measurement = $measurementModel->findById($id);
        if (!$measurement || $measurement['user_id'] != $_SESSION['user_id']) {
            $this->notFound();
        }
        $measurementModel->delete($id);
        $this->setFlash('Merenje obrisano.', 'success');
        $this->redirect('/measurements');
    }
}
