/**
 * Dynamically creates a footer template and appends it to the body of the HTML document.
 *
 * This script generates a footer element with specific content and styling.
 * It includes author information, a quote, and a link to the author's LinkedIn profile.
 * The footer is structured using Bootstrap classes for responsiveness and alignment.
 */

// Create a new template element for the footer
const headertemplate = document.createElement("template");

// Set the inner HTML content of the template with the footer structure
headertemplate.innerHTML =
  '<header class="bd-header bg-dark py-3 px-3 align-items-stretch border-bottom border-dark">' +
  '<div class="container-fluid d-flex align-items-center">' +
  '<h1 class="d-flex align-items-center fs-4 text-white mb-0">' +
  document.title +
  "</h1></div></header>";

// Append the content of the template to the body of the document
document.body.appendChild(headertemplate.content);
