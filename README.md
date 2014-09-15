#Pages2Pdf
Module for ProcessWire that helps generating dynamic PDF files from pages with the library [mPDF](http://www.mpdf1.com/mpdf/index.php).
The PDF output is customizable with ProcessWire templates.

##Installation
Please take a look at the following guide: http://modules.processwire.com/install-uninstall/

###Important: Update to v.1.1.0+
Version 1.1.0 was a major refactoring of the module. The PDF engine was switched from TCPDF to mPDF, which has superior support for rendering HTML/CSS. Furthermore, creating the PDF files was delegated to a separate module called *WirePDF*. Some settings related to the configuration of the PDF layout (margins, page format...) were moved to this module. Before you update, please check out the [instructions here](https://processwire.com/talk/topic/3008-module-pages2pdf/?p=67797) and make sure that you test the rendering of the PDF files.

##Configuration
After installing the module, the following config options are available:

* **Enabled templates** Select the templates where the module is allowed to create/store PDF files
* **Print header** Check to print a header in the PDF files
* **Print footer** Check to print a footer in the PDF files
* **Cache time** Time in seconds how long the created PDF files are cached before they are created again
* **PDF filename** Filename of the PDF files. Use placeholders *{page.name}* and *{page.id}* as placeholders for the page's name and ID.
* **GET variable** Name of the GET variable used when requesting a PDF file
* **Creation mode** Should PDF files be generated and cached on click (when requesting a download) or when saving pages in the admin

More configuration options are available in the module *WirePDF*.

##Using the module
The goal of this module is to support you creating/downloading PDF files for certain templates. After the installation, you should find a new folder "pages2pdf" in your "/site/templates/" directory. This folder contains the (ProcessWire) templates where you define the markup of the PDF files:

* `default.php` Default markup if no template corresponding to the page's template is found
* `_header.php` Header markup
* `_footer.php` Footer markup
* `styles.css` CSS styles

Let's say you want to offer downloading a PDF file for all pages with the template "skyscraper". First of all, you need to enable the template in the module's config options. Then, create a corresponding template file `skyscraper.php` in the  "/site/templates/pages2pdf/" directory and define the markup of the skyscraper PDF. You have the full ProcessWire API available. Note that HTML/CSS support is limited, you may want to check out what [HTML tags](http://mpdf1.com/manual/index.php?tid=256) / [CSS styles](http://mpdf1.com/manual/index.php?tid=34) are supported by mPDF.

Now what's left is to output a link in the skyscraper template where the user can click and download the PDF file:
```php
echo $modules->get('Pages2Pdf')->render();
```
The render method takes an array of options that you can use to customize the output:
```php
$options = array(
  'title' => 'Print PDF',
  'markup' => '<a href="{url}" target="_blank">{title}</a>',
  'page_id' => '', // Pass a page ID if you want to download the PDF for another page
);
echo $modules->get('Pages2Pdf')->render($options);
```
Since v.1.1.0 calling the render() method is no longer required. You can also write the link to requesting/downloading a PDF file by yourself:
```php
echo '<a href="' . $page->url . '?pages2pdf=1">Download PDF</a>';
// Or to download a PDF file from another page
echo '<a href="' . $page->url . '?pages2pdf=' . $pages->get('/my/page/')->id . '">Download PDF</a>';
```

Depending on the chosen creation mode, the PDF file is stored for caching before downloading or after saving a page. When the user requests a download of a PDF, the file is only re-created if the cache is expired or if debug mode is on.

#WirePDF
This module is a wrapper around the mPDF library. It is used by the Pages2Pdf module to create and store the PDF files, but can also be used independently to create/store/download PDF files.

## Configuration
The most important configuration options for mPDF are available in the module configs:
* **Page orientation** P for Portrait, L for Landscape
* **Page format** Format of the PDF file, A4,A3...
* **Margins** Left, Top, Right and Bottom margins of the document in mm
* **Header margin top** Margin of the header (top) in mm
* **Footer margin bottom** Margin of the footer (bottom) in mm
* **Print header on first page** Check to print the header also on the first page of a PDF file
* **Mode** mPDF mode, change if you need support for additional languages/fonts. [Docs] (http://mpdf1.com/manual/index.php?tid=184)
* **Default font** Default font. Included fonts are: Helvetica/Arial and Times/Courier
* **Default font size** Default font size in pt
* **CSS file** Path and filename of a CSS file containing default styles for the PDF HTML markup
* **Author** Author of the PDF

##Using the module
Here are some examples how you can create and store/download a PDF file:
```php
$pdf = $modules->get('WirePDF');

// Define the main markup
$pdf->markupMain = $config->paths->templates . 'pdf_template.php';

// Header markup, header is only printed if you provide the markup
$pdf->markupHeader = $config->paths->templates . 'pdf_header.php';

// The same goes for the footer
$pdf->markupFooter = $config->paths->templates . 'pdf_footer.php';

// You can override any of the module config options if you have other needs, e.g.
$pdf->pageOrientation = 'L';
$pdf->pageFormat = 'A3';
$pdf->bottomMargin = 10;

// Saving the PDF file to disk
$pdf->save('/path/to/my-pdf-file.pdf');

// ... or request download
$pdf->download('pdf-filename.pdf');

// Setting the markup: Set path to a ProcessWire TemplateFile, an instance of a TemplateFile or just markup
// The lines below are equivalent
$pdf->markupMain = $config->paths->templates . 'pdf_template.php';
$pdf->markupMain = new TemplateFile($config->paths->templates . 'pdf_template.php');
$template = new TemplateFile($config->paths->templates . 'pdf_template.php');
$pdf->markupMain = $template->render();
```

For advanced usage, you can also get the mPDF instance from the module:

```php
$pdf = $modules->get('WirePDF');

// Get mPDF instance
$mpdf = $pdf->mpdf;

// Set back mPDF instance
$pdf->mpdf = $mpdf;
```
