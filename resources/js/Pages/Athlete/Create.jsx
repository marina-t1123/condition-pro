import {
    Box,
    ChakraProvider,
    defaultSystem,
    Input,
    NativeSelect,
    Stack,
    Text,
    VStack,
    HStack,
    RadioGroup,
    Textarea,
    Button
} from '@chakra-ui/react';
import { Link, useForm } from '@inertiajs/react';
import CustomHeader from '@/Layouts/CustomHeader';
import { useEffect, useState } from 'react';


const Create = (props) => {

    // propsから、チーム・種目・ポジションと性別情報を取得
    const { team_event_positions, sexes } = props;
    console.log(team_event_positions);

    // 性別のradioボタンの値
    const items = [
        { label: "男性", value: "1"},
        { label: "女性", value: "2"},
        { label: "その他", value: "3"}
    ];

    // 選択したチーム情報のstate管理
    const [selectedTeam, setSelectedTeam] = useState([]);
    console.log(selectedTeam);

    // 選択可能なポジション情報のstate
    const [availablePositions, setAvailablePositions] = useState([]);
    console.log(availablePositions);

    // InertiaのuseFormを使用して、フォームデータの状態(State)を管理
    const { data, setData, post, errors } = useForm({
        'team_id': '',
        'event_name': '',
        'm_event_position_id': '',
        'athlete_name': '',
        'sex_id': '',
        'birthday': '',
        'memo': ''
    });
    console.log(data);

    // フォームの入力内容が変更された際の処理
    const handleChange = (e) => {
        setData({ ...data, [e.target.name]: e.target.value });
    }

    // チーム選択時の種目・種目に紐づくポジション情報を取得・表示する
    useEffect(() => {
        console.log('useEffectの実行処理');

        if(data.team_id) {
            // フォームで選択されたチーム情報を取得
            const selectedTeamData = team_event_positions.find(team => team.id.toString() === data.team_id);
            // チーム情報のstate更新
            setSelectedTeam(selectedTeamData || '');

            // チーム選択時に種目IDを設定
            setData({...data, event_name: selectedTeamData.m_event.event_name});

            //それぞれの種目に紐づくポジション・階級を取得する
            setAvailablePositions(selectedTeamData.m_event.m_event_positions);
        }

    }, [data.team_id]);

    // フォームが送信される際の処理
    const handleSubmit = (e) => {
        console.log('送信処理');
        e.preventDefault();

        post(route('athlete.store', data));
    }

    return (
        <ChakraProvider value={defaultSystem}>

            <CustomHeader />

            {/* メイン */}
            <Box className='main' width='80%' m='auto' bg='white' marginTop='20px' p='6' boxShadow='md'>
                <Box textAlign='center' mb='6'>
                    <Text fontSize='25px' mb='2'>選手登録フォーム</Text>
                </Box>

                <Box as='form' onSubmit={handleSubmit}>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>チーム</Text>
                        <NativeSelect.Root>
                            <NativeSelect.Field placeholder='チームを選択してください' value={data.team_id} name='team_id' onChange={handleChange}>
                                {team_event_positions.map((team, i) => <option key={i} value={team.id}>{team.team_name}</option>)}
                            </NativeSelect.Field>
                        </NativeSelect.Root>
                        <Text color='red.500'>{errors.team_id}</Text>
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>種目</Text>
                        <Input
                            placeholder='各チームに登録されている種目が表示されます'
                            type='text'
                            id='event_name'
                            name='event_name'
                            value={data.event_name || ''}
                            disabled
                        />
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>ポジション・階級</Text>
                        <NativeSelect.Root>
                            <NativeSelect.Field placeholder='ポジション・階級を選択してください' value={data.m_event_position_id} name='m_event_position_id' onChange={handleChange}>
                                {availablePositions.map((availablePosition, i) =>
                                    <option key={i} value={availablePosition.id}>
                                        {availablePosition.event_position_name}
                                    </option>
                                )}
                            </NativeSelect.Field>
                        </NativeSelect.Root>
                        <Text color='red.500'>{errors.m_event_position_id}</Text>
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>選手名</Text>
                        <Input
                            placeholder='必須入力です'
                            type='text'
                            id='athlete_name'
                            name='athlete_name'
                            value={data.athlete_name}
                            onChange={handleChange}
                        />
                        {errors.athlete_name && <Text color='red.500'>{errors.athlete_name}</Text>}
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>性別</Text>
                        <RadioGroup.Root value={data.sex_id} name='sex_id' defaultValue='1' onChange={handleChange}>
                            <HStack gap="6">
                                {items.map((item) => (
                                    <RadioGroup.Item key={item.value} value={item.value}>
                                        <RadioGroup.ItemHiddenInput />
                                        <RadioGroup.ItemIndicator />
                                        <RadioGroup.ItemText>{item.label}</RadioGroup.ItemText>
                                    </RadioGroup.Item>
                                ))}
                            </HStack>
                        </RadioGroup.Root>
                        {errors.sex_id && <Text color='red.500'>{errors.sex_id}</Text>}
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>生年月日</Text>
                        <Input
                            placeholder='必須入力です'
                            type='date'
                            id='birthday'
                            name='birthday'
                            value={data.birthday}
                            onChange={handleChange}
                        />
                        {errors.birthday && <Text color='red.500'>{errors.birthday}</Text>}
                    </Stack>
                    <Stack gap="4" w="full" marginTop='1rem'>
                        <Text>メモ・備考</Text>
                        <Textarea
                            size="xl"
                            type="text"
                            id='memo'
                            name="memo"
                            value={data.memo}
                            onChange={handleChange}
                        />
                        {errors.memo && <Text color="red.500">{errors.memo}</Text>}
                    </Stack>
                    <HStack display='flex' justifyContent='center' gap='4' p='0.5rem' m='6'>
                        <Button as={Link} href={`/athletes`} color='white' bg='gray.500' size='lg' p='5' width='30%'>戻る</Button>
                        <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='30%'>登録</Button>
                    </HStack>
                </Box>

            </Box>


        </ChakraProvider>
    )


}

export default Create;
