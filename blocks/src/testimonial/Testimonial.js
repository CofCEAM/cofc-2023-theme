const Testimonial = ({ attributes }) => {
  function prettifyDateString(dateString) {
    const date = new Date(dateString);
    const months = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    const month = months[date.getMonth()];
    const day = date.getDate();
    const year = date.getFullYear();
    return `${month} ${day}, ${year}`;
  }
  return (
    <div class="wysiwyg  component">
      <div class="wysiwyg__inner  user-markup">
        <div class="quote component">
          <div class="quote__wrapper">
            <div class="quote__image"></div>
          </div>
          <blockquote class="quote__inner">
            <p class="quote__copy">{attributes.quote}</p>
            <cite class="quote__cite">
              {attributes.name} - {prettifyDateString(attributes.date)}
            </cite>
          </blockquote>
        </div>
      </div>
    </div>
  );
};
export default Testimonial;
