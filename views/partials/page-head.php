<?php
// views/partials/page-head.php
// Requires: $pageTitle (string)
$pageTitle = $pageTitle ?? 'MBKM Polibatam';
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<title><?= htmlspecialchars($pageTitle) ?> — MBKM Polibatam</title>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Google Fonts: Inter & Plus Jakarta Sans -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: {
                        50: '#f5f3ff',
                        100: '#e0e7ff',
                        200: '#ddd6fe',
                        500: '#6366f1',
                        600: '#4f46e5',
                        700: '#4338ca',
                        800: '#3730a3',
                        900: '#312e81',
                    },
                    accent: {
                        50: '#f0fdf4',
                        100: '#dcfce7',
                        500: '#10b981',
                        600: '#059669',
                    }
                },
                fontFamily: {
                    sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                }
            }
        }
    }
</script>

<style>
    body { 
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; 
        background: #f8fafc;
        color: #0f172a;
    }
    /* Scrollbar thin */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #f1f5f9; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Custom Premium Elements */
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    
    .glass-card-dark {
        background: rgba(15, 23, 42, 0.9);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .hover-lift {
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -8px rgba(99, 102, 241, 0.15), 0 4px 12px -2px rgba(99, 102, 241, 0.1);
    }

    /* Glow text */
    .glow-text {
        text-shadow: 0 0 20px rgba(99, 102, 241, 0.2);
    }

    /* Modern Table overrides */
    table.dataTable {
        border-collapse: separate !important;
        border-spacing: 0 8px !important;
        width: 100% !important;
    }
    table.dataTable tbody tr {
        background: #ffffff !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
        border-radius: 12px !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    table.dataTable tbody tr:hover {
        transform: scale(1.005);
        box-shadow: 0 4px 12px 0 rgba(0, 0, 0, 0.05) !important;
        background: #f8fafc !important;
    }
    table.dataTable tbody td {
        border: none !important;
        padding: 14px 16px !important;
    }
    table.dataTable tbody td:first-child {
        border-top-left-radius: 12px !important;
        border-bottom-left-radius: 12px !important;
    }
    table.dataTable tbody td:last-child {
        border-top-right-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
    }
    table.dataTable thead th {
        border: none !important;
        background: transparent !important;
        color: #64748b !important;
        font-weight: 600 !important;
        font-size: 0.75rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        padding: 12px 16px !important;
    }
</style>
