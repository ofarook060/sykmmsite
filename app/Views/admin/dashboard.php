<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin System Control Panel</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ddd; padding-bottom: 10px; margin-bottom: 20px; }
        .stats-grid { display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap; }
        .stat-card { background: #fff; padding: 20px; border-radius: 8px; flex: 1; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center; }
        .stat-card h2 { margin: 5px 0; font-size: 2.5rem; color: #007bff; }
        .actions { margin-bottom: 30px; background: #e9ecef; padding: 15px; border-radius: 8px; }
        .btn { display: inline-block; padding: 10px 15px; background: #007bff; color: #fff; text-decoration: none; border-radius: 4px; font-weight: bold; margin-right: 10px; }
        .btn-green { background: #28a745; }
        .btn-logout { background: #dc3545; }
        .data-tables { display: flex; gap: 20px; flex-wrap: wrap; }
        .table-box { background: #fff; padding: 20px; border-radius: 8px; flex: 1; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
        @media (max-width: 768px) {
            .dashboard-header { flex-direction: column; gap: 10px; text-align: center; }
            .stats-grid { flex-direction: column; }
            .stat-card { flex: none; }
            .data-tables { flex-direction: column; }
            .table-box { flex: none; overflow-x: auto; }
        }
    </style>
</head>
<body>
    <?= view('partials/header') ?>
    <div style="padding: 20px;">
    <div class="dashboard-header">
        <h1>Welcome Back, <?= esc(session()->get('username')) ?></h1>
        <a href="/logout" class="btn btn-logout">Logout</a>
    </div>


    <!-- Stats Summary Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Active Properties</h3>
            <h2><?= $total_properties ?></h2>
        </div>
        <div class="stat-card">
            <h3>Total Blog Posts</h3>
            <h2><?= $total_posts ?></h2>
        </div>
    </div>

    <!-- Management Action Center -->
    <div class="actions">
        <h3>Quick Operations</h3>
        <a href="/properties/create" class="btn">+ Add New Property</a>
        <a href="/posts/create" class="btn btn-green">+ Publish Blog Post</a>
        <a href="/properties" target="_blank" style="margin-left: 20px;">View Public Listings &rarr;</a>
        <a href="/posts" target="_blank" style="margin-left: 20px;">View Public Blog &rarr;</a>
    </div>

    <!-- Data Tables Grid Overview -->
    <div class="data-tables">
        
        <!-- Properties Table Box -->
        <div class="table-box">
            <h3>Recent Property Entries</h3>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_properties as $prop): ?>
                    <tr>
                        <td><?= esc($prop['title']) ?></td>
                        <td><?= esc($prop['location'] ?? 'N/A') ?></td>
                        <td><?= esc($prop['price'] ?? '0') ?></td>
                        <td>
                            <a href="/properties/edit/<?= esc($prop['id']) ?>" class="btn" style="padding: 5px 10px; font-size: 0.8rem;">Edit</a>
                            <form method="post" action="/properties/delete/<?= esc($prop['id']) ?>" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-logout" style="padding: 5px 10px; font-size: 0.8rem;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Blog Posts Table Box -->
        <div class="table-box">
            <h3>Recent Blog Posts</h3>
            <table>
                <thead>
                    <tr>
                        <th>Post Title</th>
                        <th>Excerpts Snippet</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_posts as $post): ?>
                    <tr>
                        <td><strong><?= esc($post['title']) ?></strong></td>
                        <td><?= esc(character_limiter($post['content'], 60)) ?></td>
                        <td>
                            <a href="/posts/edit/<?= esc($post['id']) ?>" class="btn" style="padding: 5px 10px; font-size: 0.8rem;">Edit</a>
                            <form method="post" action="/posts/delete/<?= esc($post['id']) ?>" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-logout" style="padding: 5px 10px; font-size: 0.8rem;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>

