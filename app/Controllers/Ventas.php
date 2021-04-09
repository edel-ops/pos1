<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VentasModel;
use App\Models\TemporalCompraModel;
use App\Models\DetalleVentaModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;



class Ventas extends BaseController
{
	protected $ventas, $temporal_compra, $detalle_venta, $productos, $configuracion;

	public function __construct()
	{
		$this->ventas = new VentasModel();
		$this->detalle_venta = new DetalleVentaModel();
		$this->productos = new ProductosModel();
		$this->configuracion = new ConfiguracionModel();
		helper(['form']);
	}

	public function index()
	{
		$datos = $this->ventas->obtener(1);
		$data = ['titulo' => 'Historial de ventas', 'datos' => $datos];

		echo view('header');
		echo view('ventas/ventas', $data);
		echo view('footer');
	}

	public function eliminados()
	{
		$datos = $this->ventas->obtener(0);
		$data = ['titulo' => 'Ventas eliminadas', 'datos' => $datos];

		echo view('header');
		echo view('ventas/eliminados', $data);
		echo view('footer');
	}

	public function venta()
	{
		echo view('header');
		echo view('ventas/caja');
		echo view('footer');
	}

	public function insertar()
	{
		$id_venta = $this->request->getPost('id_venta');
		$total = preg_replace('/[\$,]/', '', $this->request->getPost('total'));
		$forma_pago = $this->request->getPost('forma_pago');
		$id_cliente = $this->request->getPost('id_cliente');

		$session = session();

		$resultadoId = $this->ventas->insertarVenta(
			$id_venta,
			$total,
			$session->id_usuario,
			$session->id_caja,
			$id_cliente,
			$forma_pago
		);

		$this->temporal_compra = new TemporalCompraModel();

		if ($resultadoId) {
			$resultadoCompra = $this->temporal_compra->porCompra($id_venta);

			foreach ($resultadoCompra as $row) {
				$this->detalle_venta->save([
					'id_venta' => $resultadoId,
					'id_producto' => $row['id_producto'],
					'nombre' => $row['nombre'],
					'cantidad' => $row['cantidad'],
					'precio' => $row['precio']
				]);

				$this->productos = new ProductosModel();
				$this->productos->actualizaStock($row['id_producto'], $row['cantidad'], '-');
			}

			$this->temporal_compra->eliminarCompra($id_venta);
		}
		return redirect()->to(base_url() . "/ventas/muestraTicket/" . $resultadoId);
	}

	function muestraTicket($id_venta)
	{
		$data['id_venta'] = $id_venta;
		echo view('header');
		echo view('ventas/ver_ticket', $data);
		echo view('footer');
	}

	function generaTicket($id_venta)
	{
		$datosVenta = $this->ventas->where('id', $id_venta)->first();
		$detalle_venta = $this->detalle_venta->select('*')->where('id_venta', $id_venta)->findAll();
		$nombreTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_nombre')->get()->getRow()->valor;
		$direccionTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_direccion')->get()->getRow()->valor;
		$leyendaTicket = $this->configuracion->select('valor')->where('nombre', 'ticket_leyenda')->get()->getRow()->valor;

		$pdf = new \FPDF('P', 'mm', array(80, 200));
		$pdf->AddPage();
		$pdf->SetMargins(5, 5, 5);
		$pdf->SetTitle("Venta");
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(60, 5, $nombreTienda, 0, 1, 'C');

		$pdf->Image(base_url() . '/images/ft.jpeg', 5, 5, 20, 15, 'JPEG');

		$pdf->SetFont('Arial', '', 9);
		$pdf->Cell(60, 5, $direccionTienda, 0, 1, 'C');

		$pdf->SetFont('Arial', '', 9);
		$pdf->Cell(60, 5, $datosVenta['fecha_alta'], 0, 1, 'C');

		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(15, 5, utf8_decode('Ticket:'), 0, 0, 'L');
		$pdf->SetFont('Arial', '', 9);
		$pdf->Cell(30, 5, $datosVenta['folio'], 0, 1, 'C');

		$pdf->Ln();

		$pdf->SetFont('Arial', 'B', 7);
		
		$pdf->Cell(7, 5, 'Cant.', 0, 0, 'L');
		$pdf->Cell(35, 5, 'Nombre', 0, 0, 'L');
		$pdf->Cell(15, 5, 'Precio', 0, 0, 'L');
		$pdf->Cell(15, 5, 'Importe', 0, 1, 'L');

		$pdf->SetFont('Arial', '', 7);

		$contador = 1;

		foreach ($detalle_venta as $row) {
			$pdf->Cell(7, 5, $row['cantidad'], 0, 0, 'L');
			$pdf->Cell(35, 5, $row['nombre'], 0, 0, 'L');
			$pdf->Cell(15, 5, $row['precio'], 0, 0, 'L');
			$importe = number_format($row['precio'] * $row['cantidad'], 2, '.', ',');
			$pdf->Cell(15, 5, 'C$' . $importe, 0, 1, 'R');
			$contador++;
		}

		$pdf->Ln();
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(70, 5, 'Total C$' . number_format($datosVenta['total'], 2, '.', ','), 0, 1, 'R');

		$pdf->Ln();
		$pdf->MultiCell(70, 5, $leyendaTicket, 0, 'C', 0);

		$this->response->setHeader('Content-Type', 'application/pdf');
		$pdf->Output("ticket.pdf", "I");
	}

	public function eliminar($id)
	{
		$productos = $this->detalle_venta->where('id_venta', $id)->findAll();

		foreach ($productos as $producto) {
			
			$this->productos->actualizaStock($producto['id_producto'], $producto['cantidad'], '+');
		}

		$this->ventas->update($id, ['activo' => 0]);

		return redirect()->to(base_url(). '/ventas');
	}
}
