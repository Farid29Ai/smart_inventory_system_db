<?php
declare(strict_types=1);

use Migrations\BaseSeed;

class SmartInventoryItemsSeed extends BaseSeed
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $categories = [
            'Stationery' => 'Barang alat tulis dan keperluan meja pejabat.',
            'IT Equipment' => 'Peralatan komputer dan teknologi.',
            'Office Supplies' => 'Keperluan operasi pejabat harian.',
            'Paper Products' => 'Kertas, buku nota dan bahan cetakan.',
            'Cleaning Supplies' => 'Bahan pembersihan dan kebersihan pejabat.',
            'Furniture' => 'Perabot pejabat.',
            'IT Accessories' => 'Aksesori komputer dan kabel.',
            'Storage & Filing' => 'Fail, kabinet dan penyimpanan dokumen.',
        ];

        $vendors = [
            'ABC Supply Sdn Bhd' => ['Encik Amir', '0123456789', 'abc@gmail.com', 'Kuala Lumpur'],
            'XYZ Office Supplies' => ['Puan Sofia', '0127788990', 'sales@xyzoffice.test', 'Shah Alam'],
            'PaperWorld Sdn Bhd' => ['Mr Tan', '0138899001', 'orders@paperworld.test', 'Petaling Jaya'],
            'TechPro Solutions' => ['Daniel Lee', '0146677881', 'hello@techpro.test', 'Cyberjaya'],
            'CleanPlus Sdn Bhd' => ['Siti Hajar', '0119988776', 'support@cleanplus.test', 'Subang Jaya'],
            'FurniHub Sdn Bhd' => ['Farhan Rahman', '0192233445', 'sales@furnihub.test', 'Klang'],
            'FileMaster Sdn Bhd' => ['Nora Izzati', '0173322110', 'admin@filemaster.test', 'Kajang'],
        ];

        foreach ($categories as $name => $description) {
            $exists = $this->fetchRow("SELECT category_id FROM category WHERE LOWER(category_name) = LOWER(" . $this->quote($name) . ") LIMIT 1");
            if (!$exists) {
                $this->execute(
                    'INSERT INTO category (category_name, description) VALUES (:name, :description)',
                    ['name' => $name, 'description' => $description]
                );
            }
        }

        foreach ($vendors as $name => $details) {
            $exists = $this->fetchRow("SELECT vendor_id FROM vendor WHERE LOWER(vendor_name) = LOWER(" . $this->quote($name) . ") LIMIT 1");
            if (!$exists) {
                $this->execute(
                    'INSERT INTO vendor (vendor_name, contact_person, phone_no, email, address) VALUES (:vendor_name, :contact_person, :phone_no, :email, :address)',
                    [
                        'vendor_name' => $name,
                        'contact_person' => $details[0],
                        'phone_no' => $details[1],
                        'email' => $details[2],
                        'address' => $details[3],
                    ]
                );
            }
        }

        $categoryIds = $this->idMap('category', 'category_id', 'category_name');
        $vendorIds = $this->idMap('vendor', 'vendor_id', 'vendor_name');

        $items = [
            ['A4 Paper', 'Stationery', 'ABC Supply Sdn Bhd', 60, 10, '1', 'items/a4-paper.png', 'Available', 'A4 copy paper for printing and photocopying.'],
            ['Laptop Dell', 'IT Equipment', 'ABC Supply Sdn Bhd', 5, 0, '1', 'items/laptop-dell.png', 'Available', 'Portable laptop for office productivity tasks.'],
            ['Pencil', 'Stationery', 'ABC Supply Sdn Bhd', 19, 20, '20', 'items/pencil.png', 'Available', 'Pencil stock for daily office writing.'],
            ['Stapler', 'Office Supplies', 'XYZ Office Supplies', 120, 15, '1', 'items/stapler.png', 'Available', 'Desktop stapler for binding printed documents.'],
            ['A4 Blue Paper', 'Paper Products', 'PaperWorld Sdn Bhd', 200, 20, '1', 'items/a4-blue-paper.png', 'Available', 'Colored A4 paper for office printing.'],
            ['Printer', 'IT Equipment', 'TechPro Solutions', 8, 0, '1', 'items/printer.png', 'Available', 'Office printer for shared departmental printing.'],
            ['Floor Cleaner', 'Cleaning Supplies', 'CleanPlus Sdn Bhd', 35, 10, '1', 'items/floor-cleaner.png', 'Available', 'General floor cleaning liquid.'],
            ['Office Chair', 'Furniture', 'FurniHub Sdn Bhd', 12, 20, '1', 'items/office-chair.png', 'Available', 'Ergonomic office chair.'],
            ['Wireless Mouse', 'IT Accessories', 'TechPro Solutions', 42, 8, '1', 'items/wireless-mouse.png', 'Available', 'Wireless mouse for workstations.'],
            ['Lever Arch File', 'Storage & Filing', 'FileMaster Sdn Bhd', 25, 8, '1', 'items/lever-arch-file.png', 'Available', 'Lever arch file for document filing.'],
            ['Whiteboard Marker', 'Stationery', 'XYZ Office Supplies', 78, 12, '1', 'items/whiteboard-marker.png', 'Available', 'Dry erase marker for meeting rooms.'],
            ['Calculator', 'Office Supplies', 'ABC Supply Sdn Bhd', 15, 20, '1', 'items/calculator.png', 'Available', 'Desktop calculator for office calculations.'],
            ['Yellow Highlighter', 'Stationery', 'XYZ Office Supplies', 85, 10, '1', 'items/yellow-highlighter.png', 'Available', 'Highlighter marker for documents.'],
            ['Keyboard', 'IT Accessories', 'TechPro Solutions', 22, 6, '1', 'items/keyboard.png', 'Available', 'Standard USB keyboard.'],
            ['Desktop Monitor', 'IT Equipment', 'TechPro Solutions', 7, 0, '1', 'items/desktop-monitor.png', 'Available', 'LED monitor for workstation use.'],
            ['USB Flash Drive', 'IT Accessories', 'TechPro Solutions', 55, 10, '1', 'items/usb-flash-drive.png', 'Available', 'USB storage device.'],
            ['Extension Plug', 'IT Accessories', 'ABC Supply Sdn Bhd', 16, 20, '1', 'items/extension-plug.png', 'Available', 'Extension power strip.'],
            ['Scissors', 'Stationery', 'ABC Supply Sdn Bhd', 24, 6, '1', 'items/scissors.png', 'Available', 'Office scissors.'],
            ['Glue Stick', 'Stationery', 'ABC Supply Sdn Bhd', 30, 10, '1', 'items/glue-stick.png', 'Available', 'Glue stick for paper documents.'],
            ['Sticky Notes', 'Paper Products', 'PaperWorld Sdn Bhd', 50, 12, '1', 'items/sticky-notes.png', 'Available', 'Sticky note pads.'],
            ['Paper Clips', 'Office Supplies', 'XYZ Office Supplies', 90, 20, '1', 'items/paper-clips.png', 'Available', 'Paper clips for documents.'],
            ['Puncher', 'Office Supplies', 'ABC Supply Sdn Bhd', 14, 20, '1', 'items/puncher.png', 'Available', 'Two-hole puncher.'],
            ['Envelope', 'Paper Products', 'PaperWorld Sdn Bhd', 100, 25, '1', 'items/envelope.png', 'Available', 'Mailing envelopes.'],
            ['Document Tray', 'Storage & Filing', 'FileMaster Sdn Bhd', 19, 20, '1', 'items/document-tray.png', 'Available', 'Stackable document tray.'],
            ['Toner Cartridge', 'IT Accessories', 'TechPro Solutions', 9, 0, '1', 'items/toner-cartridge.png', 'Available', 'Printer toner cartridge.'],
            ['Printer Ink', 'IT Accessories', 'TechPro Solutions', 11, 20, '1', 'items/printer-ink.png', 'Available', 'Printer ink cartridge.'],
            ['Whiteboard Eraser', 'Office Supplies', 'XYZ Office Supplies', 21, 8, '1', 'items/whiteboard-eraser.png', 'Available', 'Whiteboard eraser.'],
            ['Cleaning Cloth', 'Cleaning Supplies', 'CleanPlus Sdn Bhd', 40, 12, '1', 'items/cleaning-cloth.png', 'Available', 'Microfiber cleaning cloth.'],
            ['Hand Sanitizer', 'Cleaning Supplies', 'CleanPlus Sdn Bhd', 18, 20, '1', 'items/hand-sanitizer.png', 'Available', 'Hand sanitizer bottle.'],
            ['Waste Bin', 'Cleaning Supplies', 'CleanPlus Sdn Bhd', 8, 0, '1', 'items/waste-bin.png', 'Available', 'Office waste bin.'],
            ['Office Desk', 'Furniture', 'FurniHub Sdn Bhd', 6, 0, '1', 'items/office-desk.png', 'Available', 'Office desk for workstations.'],
            ['Filing Cabinet', 'Storage & Filing', 'FurniHub Sdn Bhd', 5, 0, '1', 'items/filing-cabinet.png', 'Available', 'Document filing cabinet.'],
            ['Webcam', 'IT Accessories', 'TechPro Solutions', 13, 20, '1', 'items/webcam.png', 'Available', 'Webcam for online meetings.'],
            ['Headset', 'IT Accessories', 'TechPro Solutions', 17, 20, '1', 'items/headset.png', 'Available', 'Headset with microphone.'],
            ['HDMI Cable', 'IT Accessories', 'TechPro Solutions', 28, 8, '1', 'items/hdmi-cable.png', 'Available', 'HDMI cable for presentations.'],
            ['Correction Tape', 'Stationery', 'ABC Supply Sdn Bhd', 0, 8, '1', 'items/correction-tape.png', 'Out of Stock', 'Correction tape for document editing.'],
        ];

        $inserted = 0;
        $updated = 0;
        foreach ($items as $item) {
            [$name, $category, $vendor, $quantity, $minimumStock, $unit, $image, $status, $description] = $item;
            $existing = $this->fetchRow("SELECT item_id FROM item WHERE item_name = " . $this->quote($name) . " LIMIT 1");
            $params = [
                'item_name' => $name,
                'description' => $description,
                'category_id' => $categoryIds[$category],
                'vendor_id' => $vendorIds[$vendor],
                'quantity_available' => $quantity,
                'minimum_stock' => $minimumStock,
                'unit' => $unit,
                'item_image' => $image,
                'status' => $status,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if ($existing) {
                $this->execute(
                    'UPDATE item SET description = :description, category_id = :category_id, vendor_id = :vendor_id, quantity_available = :quantity_available, minimum_stock = :minimum_stock, unit = :unit, item_image = :item_image, status = :status, updated_at = :updated_at WHERE item_id = :item_id',
                    [
                        'description' => $params['description'],
                        'category_id' => $params['category_id'],
                        'vendor_id' => $params['vendor_id'],
                        'quantity_available' => $params['quantity_available'],
                        'minimum_stock' => $params['minimum_stock'],
                        'unit' => $params['unit'],
                        'item_image' => $params['item_image'],
                        'status' => $params['status'],
                        'updated_at' => $params['updated_at'],
                        'item_id' => (int)$existing['item_id'],
                    ]
                );
                $updated++;
                continue;
            }

            $this->execute(
                'INSERT INTO item (item_name, description, category_id, vendor_id, quantity_available, minimum_stock, unit, item_image, status, created_at, updated_at) VALUES (:item_name, :description, :category_id, :vendor_id, :quantity_available, :minimum_stock, :unit, :item_image, :status, :created_at, :updated_at)',
                $params
            );
            $inserted++;
        }

        $io = $this->getIo();
        if ($io) {
            $io->out(sprintf('SmartInventoryItemsSeed completed: %d inserted, %d updated.', $inserted, $updated));
        }
    }

    private function idMap(string $table, string $idField, string $nameField): array
    {
        $rows = $this->fetchAll(sprintf('SELECT %s, %s FROM %s', $idField, $nameField, $table));
        $map = [];
        foreach ($rows as $row) {
            $map[(string)$row[$nameField]] = (int)$row[$idField];
        }

        return $map;
    }

    private function quote(string $value): string
    {
        return "'" . str_replace("'", "''", $value) . "'";
    }
}
