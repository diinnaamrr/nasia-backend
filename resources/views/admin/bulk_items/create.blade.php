<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Add Items</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Bulk Add Items</h2>
        <form id="bulk-item-form" enctype="multipart/form-data">
            @csrf
            <div id="item-container">
                <div class="item-box border p-3 mb-3">
                    <h5>Item #1</h5>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="items[0][name]" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SKU</label>
                        <input type="text" name="items[0][sku]" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="items[0][image]" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Module ID</label>
                        <input type="text" name="items[0][module_id]" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Store</label>
                        <select name="items[0][store_id]" class="form-control" required>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="items[0][category_id]" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="items[0][price]" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Recommended</label>
                        <input type="hidden" name="items[0][recommended]" value="0">
                        <input type="checkbox" name="items[0][recommended]" value="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Organic</label>
                        <input type="hidden" name="items[0][organic]" value="0">
                        <input type="checkbox" name="items[0][organic]" value="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Approved</label>
                        <input type="hidden" name="items[0][is_approved]" value="0">
                        <input type="checkbox" name="items[0][is_approved]" value="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Halal</label>
                        <input type="hidden" name="items[0][is_halal]" value="0">
                        <input type="checkbox" name="items[0][is_halal]" value="1">
                    </div>
                </div>
            </div>

            <button type="button" id="add-item-btn" class="btn btn-primary">Add Another Item</button>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>

        <div id="message" class="mt-3"></div>
    </div>

    <script>
        let itemIndex = 1;

        $("#add-item-btn").click(function () {
            let newItem = `
                <div class="item-box border p-3 mb-3">
                    <h5>Item #${itemIndex + 1}</h5>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="items[${itemIndex}][name]" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SKU</label>
                        <input type="text" name="items[${itemIndex}][sku]" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="items[${itemIndex}][image]" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Module ID</label>
                        <input type="text" name="items[${itemIndex}][module_id]" class="form-control" required>
                    </div>
<div class="mb-3">
    <label class="form-label">Stock</label>
    <input type="number" name="items[${itemIndex}][stock]" class="form-control">
</div>

                    <div class="mb-3">
                        <label class="form-label">Store</label>
                        <select name="items[${itemIndex}][store_id]" class="form-control" required>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="items[${itemIndex}][category_id]" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="items[${itemIndex}][price]" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Recommended</label>
                        <input type="hidden" name="items[${itemIndex}][recommended]" value="0">
                        <input type="checkbox" name="items[${itemIndex}][recommended]" value="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Organic</label>
                        <input type="hidden" name="items[${itemIndex}][organic]" value="0">
                        <input type="checkbox" name="items[${itemIndex}][organic]" value="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Approved</label>
                        <input type="hidden" name="items[${itemIndex}][is_approved]" value="0">
                        <input type="checkbox" name="items[${itemIndex}][is_approved]" value="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Halal</label>
                        <input type="hidden" name="items[${itemIndex}][is_halal]" value="0">
                        <input type="checkbox" name="items[${itemIndex}][is_halal]" value="1">
                    </div>
                </div>
            `;
            $("#item-container").append(newItem);
            itemIndex++;
        });

        $("#bulk-item-form").submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.bulk_items.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $("#message").html(`<div class="alert alert-success">${response.success}</div>`);
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '<ul>';
                    for (let key in errors) {
                        errorMessages += `<li>${errors[key][0]}</li>`;
                    }
                    errorMessages += '</ul>';
                    $("#message").html(`<div class="alert alert-danger">${errorMessages}</div>`);
                }
            });
        });
    </script>

</body>
</html>
