@extends('layouts.app')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1>🛒 Terminal Punto de Venta</h1>
        <p>Selecciona productos o escanea código de barras</p>
    </div>
    <a href="{{ route('ventas.index') }}" class="btn" style="background: #4b5563;">← Volver</a>
</div>

@if($errors->has('stock'))
    <div style="background: #fef2f2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #fecaca; font-weight: bold;">
        {{ $errors->first('stock') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
    <!-- Selector de Productos -->
    <div class="card" style="padding: 20px;">
        <h3 style="margin-top: 0; color: #111827; font-size: 15px;">🔍 Buscar / Seleccionar Producto</h3>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 12px; font-weight: bold; margin-bottom: 5px;">Selecciona del Inventario:</label>
            <select id="select-producto" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white;">
                <option value="">-- Elige un producto --</option>
                @foreach($productos as$prod)
                    <option value="{{ $prod->id }}" data-nombre="{{ $prod->nombre }}" data-precio="{{ $prod->precio_venta }}" data-stock="{{ $prod->stock }}" data-codigo="{{ $prod->codigo }}">
                        {{ $prod->nombre }} -${{ number_format($prod->precio_venta, 2) }} (Stock: {{$prod->stock }})
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <label style="display: block; font-size: 12px; font-weight: bold; margin-bottom: 5px;">Cantidad:</label>
                <input type="number" id="input-cantidad" value="1" min="1" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
            </div>
            <div style="display: flex; align-items: flex-end;">
                <button type="button" onclick="agregarAlCarrito()" class="btn btn-success" style="padding: 10px 16px;">➕ Agregar</button>
            </div>
        </div>
    </div>

    <!-- Carrito de Compras y Cobro -->
    <div class="card" style="padding: 20px;">
        <h3 style="margin-top: 0; color: #111827; font-size: 15px;">📋 Ticket de Venta Actual</h3>

        <form action="{{ route('ventas.store') }}" method="POST" id="form-venta">
            @csrf
            
            <div style="max-height: 250px; overflow-y: auto; margin-bottom: 15px; border: 1px solid #e5e7eb; border-radius: 6px;">
                <table style="width: 100%; font-size: 13px;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th style="padding: 8px;">Producto</th>
                            <th style="padding: 8px;">Cant.</th>
                            <th style="padding: 8px;">Subtotal</th>
                            <th style="padding: 8px; text-align: center;"></th>
                        </tr>
                    </thead>
                    <tbody id="tabla-carrito">
                        <tr id="empty-cart-msg">
                            <td colspan="4" style="text-align: center; color: #9ca3af; padding: 20px;">
                                No hay productos agregados a la venta.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Totales y Métodos de Pago -->
            <div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 18px; font-weight: 800; margin-bottom: 10px;">
                    <span>TOTAL:</span>
                    <span style="color: #16a34a;" id="texto-total">$0.00</span>
                </div>

                <div style="margin-bottom: 10px;">
                    <label style="display: block; font-size: 12px; font-weight: bold; margin-bottom: 5px;">Método de Pago:</label>
                    <select name="metodo_pago" required style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; background: white;">
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta">Tarjeta de Débito / Crédito</option>
                        <option value="Transferencia">Transferencia / SPEI</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: bold; margin-bottom: 5px;">Paga con ($):</label>
                    <input type="number" step="0.01" name="pago_con" id="input-pago-con" oninput="calcularCambio()" placeholder="0.00" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px;">
                    <div style="margin-top: 5px; font-size: 12px; font-weight: bold; color: #4b5563;">
                        Cambio: <span id="texto-cambio" style="color: #2563eb;">$0.00</span>
                    </div>
                </div>
            </div>

            <button type="submit" id="btn-cobrar" disabled class="btn btn-success" style="width: 100%; padding: 12px; font-size: 16px; font-weight: bold; text-align: center; justify-content: center;">
                💳 COMPLETAR Y COBRAR
            </button>
        </form>
    </div>
</div>

<script>
    let carrito = [];
    let totalVenta = 0;

    function agregarAlCarrito() {
        const select = document.getElementById('select-producto');
        const productoId = select.value;
        if (!productoId) return;

        const option = select.options[select.selectedIndex];
        const nombre = option.getAttribute('data-nombre');
        const precio = parseFloat(option.getAttribute('data-precio'));
        const stockMax = parseInt(option.getAttribute('data-stock'));
        const cantidad = parseInt(document.getElementById('input-cantidad').value) || 1;

        // Verificar si ya existe en carrito
        const existe = carrito.find(item => item.id === productoId);
        if (existe) {
            if (existe.cantidad + cantidad > stockMax) {
                alert('No hay suficiente stock disponible para este producto.');
                return;
            }
            existe.cantidad += cantidad;
            existe.subtotal = existe.cantidad * precio;
        } else {
            if (cantidad > stockMax) {
                alert('No hay suficiente stock disponible para este producto.');
                return;
            }
            carrito.push({ id: productoId, nombre, precio, cantidad, subtotal: precio * cantidad });
        }

        renderCarrito();
        select.value = "";
        document.getElementById('input-cantidad').value = "1";
    }

    function eliminarDelCarrito(index) {
        carrito.splice(index, 1);
        renderCarrito();
    }

    function renderCarrito() {
        const tbody = document.getElementById('tabla-carrito');
        tbody.innerHTML = '';
        totalVenta = 0;

        if (carrito.length === 0) {
            tbody.innerHTML = `<tr id="empty-cart-msg"><td colspan="4" style="text-align: center; color: #9ca3af; padding: 20px;">No hay productos agregados a la venta.</td></tr>`;
            document.getElementById('btn-cobrar').disabled = true;
        } else {
            document.getElementById('btn-cobrar').disabled = false;
            carrito.forEach((item, index) => {
                totalVenta += item.subtotal;
                tbody.innerHTML += `
                    <tr>
                        <td style="padding: 8px;">
                            ${item.nombre}
                            <input type="hidden" name="productos[${index}][id]" value="${item.id}">
                        </td>
                        <td style="padding: 8px;">
                            ${item.cantidad}
                            <input type="hidden" name="productos[${index}][cantidad]" value="${item.cantidad}">
                        </td>
                        <td style="padding: 8px;"><strong>$${item.subtotal.toFixed(2)}</strong></td>
                        <td style="padding: 8px; text-align: center;">
                            <button type="button" onclick="eliminarDelCarrito(${index})" style="background: none; border: none; color: #dc2626; cursor: pointer; font-weight: bold;">✕</button>
                        </td>
                    </tr>
                `;
            });
        }

        document.getElementById('texto-total').innerText = '$' + totalVenta.toFixed(2);
        calcularCambio();
    }

    function calcularCambio() {
        const pagoCon = parseFloat(document.getElementById('input-pago-con').value) || 0;
        const cambio = Math.max(pagoCon - totalVenta, 0);
        document.getElementById('texto-cambio').innerText = '$' + cambio.toFixed(2);
    }
</script>
@endsection