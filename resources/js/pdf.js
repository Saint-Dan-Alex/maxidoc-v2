// const { PDFDocument, StandardFonts, rgb } = require('pdf-lib');
// const fs = require('fs');

import { PDFDocument, StandardFonts, rgb } from 'pdf-lib';
import fs from 'fs';

// Load the PDF template
const pdfTemplatePath = 'path/to/your/pdf/template.pdf';
const pdfTemplateBytes = fs.readFileSync(pdfTemplatePath);

// Image data (base64-encoded)
const imageData = 'data:image/png;base64,iVBORw0KG...'; // Replace with your actual base64 image data

// Load the PDF document
const pdfDoc = await PDFDocument.load(pdfTemplateBytes);

// Embed the image
const image = await pdfDoc.embedPng(imageData);

// Get the first page of the PDF (assuming there is only one page)
const page = pdfDoc.getPages()[0];

// Set the image dimensions and position
const x = 100;
const y = 100;
const width = 200;
const height = 100;

// Draw the image onto the page
page.drawImage(image, {
    x,
    y,
    width,
    height,
});

// Save the modified PDF
const modifiedPdfBytes = await pdfDoc.save();
const outputFilePath = 'path/to/your/output/file.pdf';
fs.writeFileSync(outputFilePath, modifiedPdfBytes);


