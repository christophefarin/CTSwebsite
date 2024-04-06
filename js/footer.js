/**
 * Dynamically creates a footer template and appends it to the body of the HTML document.
 *
 * This script generates a footer element with specific content and styling.
 * It includes author information, a quote, and a link to the author's LinkedIn profile.
 * The footer is structured using Bootstrap classes for responsiveness and alignment.
 */

// Create a new template element for the footer
const footertemplate = document.createElement("template");

// Set the inner HTML content of the template with the footer structure
footertemplate.innerHTML =
  '<div class="modal" id="myMotionslegales">' +
  '<div class="modal-dialog modal-dialog-scrollable modal-lg">' +
  '<div class="modal-content">' +
  '<div class="modal-header text-center">' +
  '<h4 class="modal-title w-100">Mentions légales</h4>' +
  '<button type="button" class="btn-close" data-bs-dismiss="modal"></button>' +
  "</div>" +
  '<div class="modal-body">' +
  "<h5>Edition du site</h5>" +
  "<p>Le site cfarin.ovh est édité par Christophe Farin <a href='contact.html' data-bs-toggle='tooltip'>Contact</a></p>" +
  "<h5>Type de site</h5>" +
  "<p>Site ayant pour but la présentation d’une application de calcul en ligne non marchande</p>" +
  "<h5>Hébergeur</h5>" +
  "<p>Le site cfarin.ovh est hébergé par la société OVH<br />" +
  "SAS au capital de 10 174 560 €<br />" +
  "RCS Lille Métropole 424 761 419 00045<br />" +
  "Code APE 2620Z<br />" +
  "N° TVA : FR 22 424 761 419<br />" +
  "Siège social : 2 rue Kellermann - 59100 Roubaix - France</p>" +
  "<h5>Termes</h5>" +
  "<p>En utilisant les services de cfarin.ovh, vous vous engagez à respecter l'ensemble des conditions et règles suivantes :" +
  "<ol class='list-group list-group-numbered'>" +
  "<li class='list-group-item border-0'>L'utilisation du site cfarin.ovh est à vos propres risques</li>" +
  "<li class='list-group-item border-0'>Vous assumez l'entière responsabilité de toutes les données transmises aux serveurs</li>" +
  "<li class='list-group-item border-0'>Vous acceptez de ne pas intégrer les services de cfarin.ovh dans vos propres applications ou dans des applications tierces</li>" +
  "<li class='list-group-item border-0'>Vous pouvez utiliser le site cfarin.ovh à des fins personnelles ou commerciales</li>" +
  "<li class='list-group-item border-0'>Nous nous réservons le droit de modifier ou de cesser l'un des services de cfarin.ovh, à tout moment</li>" +
  "<li class='list-group-item border-0'>Nous nous réservons le droit de modifier les termes de cet accord sans préavis</li>" +
  "<li class='list-group-item border-0'>Le site cfarin.ovh n'offre aucune garantie</li></ol></div>" +
  "</div>" +
  "</div>" +
  "</div>" +
  '<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 px-3 my-4 border-top" id="contact">' +
  '<div class="col-md-4 d-flex align-items-center"><span class="text-muted">© 2024 Christophe FARIN</span></div>' +
  '<div class="col-md-4 d-flex align-items-center justify-content-center">' +
  '<span class="text-muted text-center"><a href="#myMotionslegales" data-bs-toggle="modal">Mentions légales</a></span></div>' +
  '<ul class="nav col-md-4 justify-content-end list-unstyled d-flex">' +
  '<li class="ms-3"><a href="https://www.linkedin.com/in/christophe-farin-564b2132/">' +
  '<i class="fa-brands fa-linkedin fa-2xl"></i></a></li></ul></footer>';

// Append the content of the template to the body of the document
document.body.appendChild(footertemplate.content);
