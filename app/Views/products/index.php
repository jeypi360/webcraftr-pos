<?= view('templates/header', ['title' => 'Products']) ?>

<style>
    .container {
        max-width: 1380px;
    }

    .products-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 30px;
    }

    .products-toolbar h1 {
        margin: 0;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 38px 22px;
    }

    .product-card {
        min-width: 0;
        text-align: center;
    }

    .product-media {
        height: 230px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }

    .product-media img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .product-placeholder {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: var(--light-green);
        color: var(--dark-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .product-name {
        margin: 14px 0 6px;
        font-size: 15px;
        font-weight: normal;
        line-height: 1.4;
    }

    .product-price {
        margin: 0 0 8px;
        font-size: 14px;
    }

    .product-stock {
        margin: 0;
        color: var(--medium-green);
        font-size: 13px;
    }

    .product-manage {
        display: inline-block;
        margin-top: 10px;
        font-size: 13px;
        color: var(--medium-green);
    }

    .product-manage summary {
        cursor: pointer;
    }

    .manage-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
    }

    .manage-actions form {
        margin: 0;
    }

    .manage-actions .button {
        margin-top: 0;
        padding: 8px 12px;
        font-size: 13px;
    }

    .manage-actions .delete-button {
        background: #e9efdf;
    }

    @media (max-width: 1050px) {
        .product-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 740px) {
        .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 480px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="products-toolbar">
    <h1>All Products</h1>
    <a class="button" href="<?= site_url('products/create') ?>">
        Add Product
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <p role="status">
        <?= esc(session()->getFlashdata('success')) ?>
    </p>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <p role="alert" style="color: #a00">
        <?= esc(session()->getFlashdata('error')) ?>
    </p>
<?php endif; ?>

<?php if (empty($products)): ?>
    <p>No products found. Select Add Product to create the first one.</p>
<?php else: ?>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <article class="product-card">
                <div class="product-media">
                    <?php if (! empty($product['image'])): ?>
                        <img
                            src="<?= base_url(
                                'uploads/products/' . rawurlencode($product['image'])
                            ) ?>"
                            alt="<?= esc($product['name'], 'attr') ?>"
                            loading="lazy"
                        >
                    <?php else: ?>
                        <div class="product-placeholder">
                            No image available
                        </div>
                    <?php endif; ?>
                </div>

                <h2 class="product-name">
                    <?= esc($product['name']) ?>
                </h2>

                <p class="product-price">
                    ₱<?= number_format((float) $product['price'], 2) ?>
                </p>

                <p class="product-stock">
                    Stock: <?= esc($product['stock_quantity']) ?>
                </p>

                <details class="product-manage">
                    <summary>Manage</summary>

                    <div class="manage-actions">
                        <a
                            class="button"
                            href="<?= site_url(
                                'products/' . $product['id'] . '/edit'
                            ) ?>"
                        >
                            Edit
                        </a>

                        <form
                            action="<?= site_url(
                                'products/' . $product['id'] . '/delete'
                            ) ?>"
                            method="post"
                            onsubmit="return confirm('Delete this product?');"
                        >
                            <?= csrf_field() ?>
                            <button
                                class="button delete-button"
                                type="submit"
                            >
                                Delete
                            </button>
                        </form>
                    </div>
                </details>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= view('templates/footer') ?>