import { get } from 'lodash';

export const ExportAsCsv = (args)=>{

    const filename = get(args, 'filename', moment().valueOf());
    const rows = get(args, 'data', []);



    const keys = Object.keys(rows[0]);

    let csv =keys.join(',');
    csv += '\r\n';

    rows.forEach((row) =>{
        for(let key in row){
            csv += row[key]+','
        }
        csv += '\r\n';
    })

    const elementId = 'link-'+moment().valueOf();
    let link  = document.createElement('a');
    link.id = elementId;
    link.setAttribute('href', 'data:text/plain;charset=utf-8,'+encodeURIComponent(csv));
    link.setAttribute('download', filename+'.csv');
    document.body.appendChild(link);
    const dowloadCsvElement = document.querySelector("#"+elementId);
    dowloadCsvElement.click();
    setTimeout(()=>{
        dowloadCsvElement.remove();
    })
}