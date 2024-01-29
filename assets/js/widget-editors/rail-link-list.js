jQuery(document).ready(function ($) {});

const removeLinkFromRailLinkList = ({ button = null }) => {
  button.parentElement.parentElement.remove();
};

const addLinkToRailLinkList = ({ button = null, linksFieldName = "links" }) => {
  const currentLinkCount = document.querySelectorAll(".rail-link-list-link").length;

  // add a new link to a Rail Link List widget in the admin view when add link is clicked
  let link = document.createElement("div");
  link.classList.add("rail-link-list-link");
  const newLinkIndex = currentLinkCount + 1;

  const linkHeading = document.createElement("h3");
  linkHeading.textContent = `Link ${newLinkIndex}`;
  link.appendChild(linkHeading);

  const label1 = document.createElement("label");
  label1.setAttribute("for", `${linksFieldName}[${newLinkIndex}][label]`);
  label1.textContent = "Link Label";
  const input1 = document.createElement("input");
  input1.classList.add("widefat");
  input1.setAttribute("type", "text");
  input1.setAttribute("name", `${linksFieldName}[${newLinkIndex}][label]`);
  input1.setAttribute("value", "");
  const div1 = document.createElement("div");
  div1.style.display = "block";
  div1.appendChild(label1);
  div1.appendChild(input1);

  const label2 = document.createElement("label");
  label2.setAttribute("for", `${linksFieldName}[${newLinkIndex}][url]`);
  label2.textContent = "Link URL";
  const input2 = document.createElement("input");
  input2.setAttribute("type", "url");
  input2.classList.add("widefat");
  input2.setAttribute("name", `${linksFieldName}[${newLinkIndex}][url]`);
  input2.setAttribute("value", "");
  const div2 = document.createElement("div");
  div2.style.display = "block";
  div2.appendChild(label2);
  div2.appendChild(input2);

  const label3 = document.createElement("label");
  label3.setAttribute("for", `${linksFieldName}[${newLinkIndex}][new_tab]`);
  label3.textContent = "Open Link in New Tab?";
  const input3_1 = document.createElement("input");
  input3_1.setAttribute("type", "radio");
  input3_1.classList.add("widefat");
  input3_1.setAttribute("checked", "checked");
  input3_1.setAttribute("name", `${linksFieldName}[${newLinkIndex}][new_tab]`);
  input3_1.setAttribute("value", "yes");
  const input3_2 = document.createElement("input");
  input3_2.setAttribute("type", "radio");
  input3_2.classList.add("widefat");
  input3_2.setAttribute("name", `${linksFieldName}[${newLinkIndex}][new_tab]`);
  input3_2.setAttribute("value", "no");
  input3_2.setAttribute("checked", "checked");
  const div3 = document.createElement("div");
  div3.style.display = "block";
  div3.appendChild(label3);
  div3.appendChild(input3_1);
  div3.appendChild(input3_2);

  const label4 = document.createElement("label");
  label4.setAttribute("for", `${linksFieldName}[${newLinkIndex}][display_description]`);
  label4.textContent = "Display Link Description?";
  const input4_1 = document.createElement("input");
  input4_1.setAttribute("type", "radio");
  input4_1.setAttribute("checked", "checked");
  input4_1.classList.add("widefat");
  input4_1.setAttribute("name", `${linksFieldName}[${newLinkIndex}][display_description]`);
  input4_1.setAttribute("value", "yes");
  const input4_2 = document.createElement("input");
  input4_2.setAttribute("type", "radio");
  input4_2.classList.add("widefat");
  input4_2.setAttribute("name", `${linksFieldName}[${newLinkIndex}][display_description]`);
  input4_2.setAttribute("value", "no");
  input4_2.setAttribute("checked", "checked");
  const div4 = document.createElement("div");
  div4.style.display = "block";
  div4.appendChild(label4);
  div4.appendChild(input4_1);
  div4.appendChild(input4_2);

  const div5 = document.createElement("div");
  const label5 = document.createElement("label");
  label5.style.display = "block";
  label5.setAttribute("for", `${linksFieldName}[${newLinkIndex}][description]`);
  label5.textContent = "Link Description";
  const textarea = document.createElement("textarea");
  textarea.setAttribute("name", `${linksFieldName}[${newLinkIndex}][description]`);
  textarea.style.width = "100%";
  textarea.classList.add("widefat");
  div5.appendChild(label5);
  div5.appendChild(textarea);

  const div6 = document.createElement("div");
  div6.classList.add("text-center");

  const removeLinkbutton = document.createElement("button");
  removeLinkbutton.setAttribute("type", "button");
  removeLinkbutton.classList.add("remove_link");
  removeLinkbutton.classList.add("components-button");
  removeLinkbutton.classList.add("is-secondary");
  removeLinkbutton.textContent = `Remove Link ${newLinkIndex}`;
  removeLinkbutton.addEventListener("click", () => {
    removeLinkFromRailLinkList({ button: removeLinkbutton });
  });
  div6.appendChild(removeLinkbutton);

  link.appendChild(div1);
  link.appendChild(div2);
  link.appendChild(div3);
  link.appendChild(div4);
  link.appendChild(div5);
  link.appendChild(div6);

  const container = button.parentElement.parentElement;

  container.appendChild(link);
};
