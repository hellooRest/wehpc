async function fetchTimeFromServer() 
{
  try 
  {
    // Lấy thời gian từ API hoặc máy chủ
    const response = await fetch('https://worldtimeapi.org/api/timezone/Etc/UTC');
    const data = await response.json();

    if (data.datetime) 
        {
      const serverDate = new Date(data.datetime);
      updateTimeDisplay(serverDate);
    } 
    else 
    {
      console.error('Không thể lấy thời gian từ máy chủ.');
    }
  } 
  catch (error) 
  {
    console.error('Lỗi khi kết nối đến máy chủ thời gian:', error);
  }
}

function updateTimeDisplay(date) 
{
  const days = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];
  const day = days[date.getUTCDay()];
  const hours = String(date.getHours()).padStart(2, '0');
  const minutes = String(date.getMinutes()).padStart(2, '0');

  document.getElementById('time').innerText = `${day}, ${hours}:${minutes}`;
}

fetchTimeFromServer();
setInterval(fetchTimeFromServer, 5000);
