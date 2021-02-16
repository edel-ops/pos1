<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\TemporalCompraModel;
use App\Models\DetalleCompraModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;



class Compras extends BaseController
{
	protected $compras, $temporal_compra, $detalle_compra, $productos, $configuracion;
	protected $reglas;

	public function __construct()
	{
		$this->compras = new ComprasModel();
		$this->detalle_compra = new DetalleCompraModel();
		$this->configuracion = new ConfiguracionModel();
		helper(['form']);
	}

	public function index($activo = 1)
	{
		$compras = $this->compras->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Historial de compras', 'compras' => $compras];

		echo view('header');
		echo view('compras/compras', $data);
		echo view('footer');
	}

	public function eliminados($activo = 0)
	{
		$compras = $this->compras->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Compras eliminadas', 'datos' => $compras];

		echo view('header');
		echo view('compras/eliminados', $data);
		echo view('footer');
	}

	public function nuevo()
	{
		echo view('header');
		echo view('compras/nuevo');
		echo view('footer');
	}

	public function insertar()
	{
		$id_compra = $this->request->getPost('id_compra');
		$total = preg_replace('/[\$,]/', '', $this->request->getPost('total'));

		$session = session();

		$resultadoId = $this->compras->insertarCompra($id_compra, $total, $session->id_usuario);

		$this->temporal_compra = new TemporalCompraModel();

		if ($resultadoId) {
			$resultadoCompra = $this->temporal_compra->porCompra($id_compra);

			foreach ($resultadoCompra as $row) {
				$this->detalle_compra->save([
					'id_compra' => $resultadoId,
					'id_producto' => $row['id_producto'],
					'nombre' => $row['nombre'],
					'cantidad' => $row['cantidad'],
					'precio' => $row['precio']
				]);

				$this->productos = new ProductosModel();
				$this->productos->actualizaStock($row['id_producto'], $row['cantidad']);
			}

			$this->temporal_compra->eliminarCompra($id_compra);
		}
		return redirect()->to(base_url() . "/compras/muestraCompraPdf/".$resultadoId);
	}

	function muestraCompraPdf($id_compra)
	{
		$data['id_compra'] = $id_compra;
		echo view('header');
		echo view('compras/ver_compra_pdf', $data);
		echo view('footer');
	}

	function generaCompraPdf($id_compra)
	{
		$datosCompra = $this->compras->where('id', $id_compra)->first();
		$detalleCompra = $this->detalle_compra->select('*')->where('id_compra', $id_compra)->findAll();
		$nombreTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_nombre')->get()->getRow()->valor;
		$direccionTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_direccion')->get()->getRow()->valor;

		$pdf = new \FPDF('P', 'mm', 'letter');
		$pdf->AddPage();
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetTitle("Compra");
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(195, 5, "Entrada de productos", 0, 1, 'C');

		$pdf->SetFont('Arial', 'B', 9);

		$pdf->Image(base_url() . '/images/ft.jpeg', 185, 10, 25, 20, 'JPEG');

		$pdf->Cell(50, 5, $nombreTienda, 0, 1, 'L');
		$pdf->Cell(18, 5, utf8_decode('Dirección: '), 0, 0, 'L');

		$pdf->SetFont('Arial', '', 9);
		$pdf->Cell(50, 5, $direccionTienda, 0, 1, 'L');

		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(23, 5, utf8_decode('Fecha y Hora: '), 0, 0, 'L');

		$pdf->SetFont('Arial', '', 9);
		$pdf->Cell(50, 5, $datosCompra['fecha_alta'], 0, 1, 'L');

		$pdf->Ln();

		$pdf->SetFont('Arial', 'B', 8);
		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Cell(196, 5, 'Detalle de productos', 1, 1, 'C', 1);

		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(14, 5, utf8_decode('N°'), 1, 0, 'L');
		$pdf->Cell(25, 5, 'Codigo', 1, 0, 'L');
		$pdf->Cell(77, 5, 'Nombre', 1, 0, 'L');
		$pdf->Cell(25, 5, 'Precio', 1, 0, 'L');
		$pdf->Cell(25, 5, 'Cantidad', 1, 0, 'L');
		$pdf->Cell(30, 5, 'Importe', 1, 1, 'L');

		$pdf->SetFont('Arial', '', 8);

		$contador = 1;

		foreach ($detalleCompra as $row) {
			$pdf->Cell(14, 5, $contador, 1, 0, 'L');
			$pdf->Cell(25, 5, $row['id_producto'], 1, 0, 'L');
			$pdf->Cell(77, 5, $row['nombre'], 1, 0, 'L');
			$pdf->Cell(25, 5, $row['precio'], 1, 0, 'L');
			$pdf->Cell(25, 5, $row['cantidad'], 1, 0, 'L');
			$importe = number_format($row['precio'] * $row['cantidad'], 2, '.', ',');
			$pdf->Cell(30, 5,'C$' . $importe, 1, 1, 'R');
			$contador++;
		}

		$pdf->Ln();
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(195, 5, 'Total C$'. number_format($datosCompra['total'], 2, '.', ','), 0, 1, 'R');

		$this->response->setHeader('Content-Type', 'application/pdf');
		$pdf->Output("compra_pdf.pdf", "I");
	}
}
